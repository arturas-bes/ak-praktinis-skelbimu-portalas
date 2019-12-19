<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserServiceRepository")
 */
class UserService
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userServices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     */
    private $serviceStartDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advertisment", mappedBy="usserService")
     */
    private $advertisments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Banner", mappedBy="userService")
     */
    private $banners;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service")
     */
    private $service;

    public function __construct()
    {
        $this->advertisments = new ArrayCollection();
        $this->banners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getServiceStartDate(): ?\DateTimeInterface
    {
        return $this->serviceStartDate;
    }

    public function setServiceStartDate(\DateTimeInterface $serviceStartDate): self
    {
        $this->serviceStartDate = $serviceStartDate;

        return $this;
    }

    /**
     * @return Collection|Advertisment[]
     */
    public function getAdvertisments(): Collection
    {
        return $this->advertisments;
    }

    public function addAdvertisment(Advertisment $advertisment): self
    {
        if (!$this->advertisments->contains($advertisment)) {
            $this->advertisments[] = $advertisment;
            $advertisment->setUsserService($this);
        }

        return $this;
    }

    public function removeAdvertisment(Advertisment $advertisment): self
    {
        if ($this->advertisments->contains($advertisment)) {
            $this->advertisments->removeElement($advertisment);
            // set the owning side to null (unless already changed)
            if ($advertisment->getUsserService() === $this) {
                $advertisment->setUsserService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Banner[]
     */
    public function getBanners(): Collection
    {
        return $this->banners;
    }

    public function addBanner(Banner $banner): self
    {
        if (!$this->banners->contains($banner)) {
            $this->banners[] = $banner;
            $banner->setUserService($this);
        }

        return $this;
    }

    public function removeBanner(Banner $banner): self
    {
        if ($this->banners->contains($banner)) {
            $this->banners->removeElement($banner);
            // set the owning side to null (unless already changed)
            if ($banner->getUserService() === $this) {
                $banner->setUserService(null);
            }
        }

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }
}
