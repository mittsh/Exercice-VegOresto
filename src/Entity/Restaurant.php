<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 */
class Restaurant
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $permalink;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $vegan;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="float")
     */
    private $ratings;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $categories;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPermalink(): ?string
    {
        return $this->permalink;
    }

    public function setPermalink(string $permalink): self
    {
        $this->permalink = $permalink;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getVegan(): ?string
    {
        return $this->vegan;
    }

    public function setVegan(string $vegan): self
    {
        $this->vegan = $vegan;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getRatings(): ?float
    {
        return $this->ratings;
    }

    public function setRatings(float $ratings): self
    {
        $this->ratings = $ratings;

        return $this;
    }

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    public function getCategoriesStrings(): array
    {
        $categories = $this->getCategories();
        if (empty($categories)) {
            $categories = [];
        }
        return array_map(function($category) {
            return self::CATEGORY_MAP[$category];
        }, $categories);
        
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime('now'));
    }

    public const CATEGORY_MAP = [
        'bar_jus'       => 'bar à jus',
        'bar_vin'       => 'bar à vin',
        'bio'           => 'bio',
        'bistro'        => 'bistro',
        'brasserie'     => 'brasserie',
        'brunch'        => 'brunch',
        'chocolatier'   => 'chocolatier',
        'crepe'         => 'crêperie',
        'cru'           => 'cru',
        'monde'         => 'cuisine du monde',
        'gastro'        => 'gastronomique',
        'glacier'       => 'glacier',
        'local'         => 'local',
        'moderne'       => 'moderne, créatif',
        'pizza'         => 'pizzeria',
        'pub'           => 'pub',
        'tarte'         => 'salades',
        'sans_gluten'   => 'sans gluten',
        'tapas'         => 'tapas',
        'tarte_vrai'    => 'tartes',
        'tradi'         => 'traditionnel, classique',
        'vege'          => 'établissement végétarien',
    ];
}
