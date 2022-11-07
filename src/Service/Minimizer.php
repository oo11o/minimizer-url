<?php

namespace App\Service;

use App\Entity\Link;
use App\Lib\Generator;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LinkRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class Minimizer
{
    private $repository;
    private $doctrine;
    private $generator;

    public function __construct(
        LinkRepository  $repository,
        ManagerRegistry $doctrine,
        Generator       $generator
    )
    {
        $this->repository = $repository;
        $this->doctrine = $doctrine;
        $this->generator = $generator;
    }

    public function find(string $shortUrl): ?object
    {
        return $this->repository->findOneBy(['short_url' => $this->clearUrl($shortUrl)]);
    }

    public function create(string $url, int $timer, string $timeType = 'seconds'): array
    {
        $entityManager = $this->doctrine->getManager();
        $shortUrl = $this->generateUrl();

        $expireDate = new \DateTime();
        $expireDate->modify("+{$timer} {$timeType}");

        $link = new Link();
        $link->setUrl($url);
        $link->setShortUrl($shortUrl);
        $link->setExpire($expireDate);
        $link->setNumberRedirect(0);
        $link->createDate();

        $entityManager->persist($link);
        $entityManager->flush();

        return [
            'shortUrl' => $shortUrl,
            'expireDate' => $expireDate->format('Y-m-d H:i:s')
        ];
    }

    public function increaseRedirect(int $id): void
    {
        $entityManager = $this->doctrine->getManager();
        $link = $entityManager->getRepository(Link::class)->find($id);
        $link->setNumberRedirect($link->getNumberRedirect() + 1);
        $link->updateDate();

        $entityManager->flush();
    }

    private function generateUrl(int $loop = 0, int $loopMax = 5): string
    {
        if ($loop > $loopMax) {
            throw new Exception('Suspicions of an endless loop');
        }

        $shortUrl = $this->generator->generateString();

        return $this->repository->findOneBy(['short_url' => $shortUrl])
            ? $this->generateUrl(++$loop)
            : $shortUrl;
    }

    public function findNoExpire(string $shortUrl): ?object
    {

        $now = \DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));

        $entityManager = $this->doctrine->getManager();
        $query = $entityManager->createQuery(
            'SELECT l
            FROM App\Entity\Link l
            WHERE l.short_url = :shortUrl
            AND l.expire > :now'
        )
            ->setParameter('shortUrl', $this->clearUrl($shortUrl))
            ->setParameter('now', $now);

        return $query->getResult()[0] ?? null;
    }

    public function findPopular(): ?array
    {
        $entityManager = $this->doctrine->getManager();
        $query = $entityManager->createQuery(
            'SELECT l
             FROM App\Entity\Link l
             ORDER BY l.number_redirect DESC'
        )->setMaxResults(5);

        return $query->getResult() ?? null;
    }

    private function clearUrl($url)
    {
        return str_replace('/', '', $url);
    }
}