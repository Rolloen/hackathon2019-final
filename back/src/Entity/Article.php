<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $url;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_first_seen;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_last_seen;

    /**
     * @ORM\Column(type="datetime")
     */
    private $showInterval;

    /**
     * @ORM\Column(type="integer")
     */
    private $articleScore;

    /**
     * @ORM\Column(type="integer")
     */
    private $social_score;

    /**
     * @ORM\Column(type="integer")
     */
    private $social_speed_sph;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $img_uri;

    /**
     * @ORM\Column(type="text")
     */
    private $content_html;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $dandelion_ngrams;

    /**
     * @ORM\Column(type="boolean")
     */
    private $newsonfire;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $categories;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $causes;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $gravite;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Departement", inversedBy="articles")
     */
    private $departements;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Region", inversedBy="articles")
     */
    private $regions;

    public function __construct()
    {
        $this->departements = new ArrayCollection();
        $this->regions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getDateFirstSeen(): ?\DateTimeInterface
    {
        return $this->date_first_seen;
    }

    public function setDateFirstSeen(\DateTimeInterface $date_first_seen): self
    {
        $this->date_first_seen = $date_first_seen;

        return $this;
    }

    public function getDateLastSeen(): ?\DateTimeInterface
    {
        return $this->date_last_seen;
    }

    public function setDateLastSeen(\DateTimeInterface $date_last_seen): self
    {
        $this->date_last_seen = $date_last_seen;

        return $this;
    }

    public function getShowInterval(): ?\DateTimeInterface
    {
        return $this->showInterval;
    }

    public function setShowInterval(\DateTimeInterface $showInterval): self
    {
        $this->showInterval = $showInterval;

        return $this;
    }

    public function getArticleScore(): ?int
    {
        return $this->articleScore;
    }

    public function setArticleScore(int $articleScore): self
    {
        $this->articleScore = $articleScore;

        return $this;
    }

    public function getSocialScore(): ?int
    {
        return $this->social_score;
    }

    public function setSocialScore(int $social_score): self
    {
        $this->social_score = $social_score;

        return $this;
    }

    public function getSocialSpeedSph(): ?int
    {
        return $this->social_speed_sph;
    }

    public function setSocialSpeedSph(int $social_speed_sph): self
    {
        $this->social_speed_sph = $social_speed_sph;

        return $this;
    }

    public function getImgUri()
    {
        return $this->img_uri;
    }

    public function setImgUri( $img_uri): self
    {
        $this->img_uri = $img_uri;

        return $this;
    }

    public function getContentHtml(): ?string
    {
        return $this->content_html;
    }

    public function setContentHtml(string $content_html): self
    {
        $this->content_html = $content_html;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDandelionNgrams()
    {
        return $this->dandelion_ngrams;
    }

    public function setDandelionNgrams($dandelion_ngrams): self
    {
        $this->dandelion_ngrams = $dandelion_ngrams;

        return $this;
    }

    public function getNewsonfire(): ?bool
    {
        return $this->newsonfire;
    }

    public function setNewsonfire(bool $newsonfire): self
    {
        $this->newsonfire = $newsonfire;

        return $this;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getCauses()
    {
        return $this->causes;
    }

    public function setCauses($causes): self
    {
        $this->causes = $causes;

        return $this;
    }

    public function getGravite()
    {
        return $this->gravite;
    }

    public function setGravite($gravite): self
    {
        $this->gravite = $gravite;

        return $this;
    }

    /**
     * @return Collection|Departement[]
     */
    public function getDepartements(): Collection
    {
        return $this->departements;
    }

    public function addDepartement(Departement $departement): self
    {
        if (!$this->departements->contains($departement)) {
            $this->departements[] = $departement;
        }

        return $this;
    }

    public function removeDepartement(Departement $departement): self
    {
        if ($this->departements->contains($departement)) {
            $this->departements->removeElement($departement);
        }

        return $this;
    }

    /**
     * @return Collection|Region[]
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Region $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions[] = $region;
        }

        return $this;
    }

    public function removeRegion(Region $region): self
    {
        if ($this->regions->contains($region)) {
            $this->regions->removeElement($region);
        }

        return $this;
    }

}
