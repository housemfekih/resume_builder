<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;

/**
 * Champ
 *
 * @ORM\Table(name="champ")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChampRepository")
 * Notifiable(name="champ")
 */
class Champ  implements  NotifiableInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomChamp", type="string", length=255)
     */
    private $nomChamp;

    /**
     * @var string
     *
     * @ORM\Column(name="typeChamp", type="string", length=255)
     */
    private $typeChamp;

    /**
     * @var string
     *
     * @ORM\Column(name="longeurChamp", type="integer")
     */
    private $longeurChamp;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomChamp
     *
     * @param string $nomChamp
     *
     * @return Champ
     */
    public function setNomChamp($nomChamp)
    {
        $this->nomChamp = $nomChamp;

        return $this;
    }

    /**
     * Get nomChamp
     *
     * @return string
     */
    public function getNomChamp()
    {
        return $this->nomChamp;
    }

    /**
     * Set typeChamp
     *
     * @param string $typeChamp
     *
     * @return Champ
     */
    public function setTypeChamp($typeChamp)
    {
        $this->typeChamp = $typeChamp;

        return $this;
    }

    /**
     * Get typeChamp
     *
     * @return string
     */
    public function getTypeChamp()
    {
        return $this->typeChamp;
    }

    /**
     * Set longeurChamp
     *
     * @param string $longeurChamp
     *
     * @return Champ
     */
    public function setLongeurChamp($longeurChamp)
    {
        $this->longeurChamp = $longeurChamp;

        return $this;
    }

    /**
     * Get longeurChamp
     *
     * @return string
     */
    public function getLongeurChamp()
    {
        return $this->longeurChamp;
    }
}
