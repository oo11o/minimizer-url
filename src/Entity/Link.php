<?php

namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LinkRepository::class)
 */
class Link
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */

    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=5, unique=true)
     */
    private $short_url;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expire;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $number_redirect;

    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $updated;

    private $timer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getShortUrl(): ?string
    {
        return $this->short_url;
    }

    public function setShortUrl(string $short_url): self
    {
        $this->short_url = $short_url;

        return $this;
    }

    public function getTimer(): ?int
    {
        return $this->timer;
    }

    public function setTimer(int $timer): self
    {
        $this->timer = $timer;

        return $this;
    }

    public function getNumberRedirect(): ?int
    {
        return $this->number_redirect;
    }

    public function setNumberRedirect(int $number_redirect): self
    {
        $this->number_redirect = $number_redirect;

        return $this;
    }

    public function getExpire(): ?\DateTimeInterface
    {
        return $this->expire;
    }

    public function setExpire(\DateTimeInterface $expire): self
    {
        $this->expire = $expire;

        return $this;
    }

    public function getCreatedDate()
    {
        return $this->created;
    }

    public function createDate()
    {
        $this->created = new \DateTime("now");
    }


    public function updateDate()
    {
        $this->updated = new \DateTime("now");
    }


}
