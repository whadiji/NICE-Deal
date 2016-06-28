<?php

namespace Entity\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Entity\EcommerceBundle\Entity\Products;

/**
 * Images.
 *
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="Entity\EcommerceBundle\Repository\ImagesRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Images
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */ 
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=255)
     */
    private $file;
    
    /**
     *  @ORM\ManyToOne(targetEntity="Products",inversedBy="image", cascade={"remove", "persist"})
     *
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return Images
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt.
     *
     * @param string $alt
     *
     * @return Images
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt.
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

     /**
      * Get alt.
      *
      * @return string 
      */
     public function getFile()
     {
         return $this->file;
     }

   // On ajoute cet attribut pour y stocker le nom du fichier temporairement
    private $tempFilename;

    // On modifie le setter de File, pour prendre en compte l'upload d'un fichier lorsqu'il en existe déjà un autre
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

      // On vérifie si on avait déjà un fichier pour cette entité
      if (null !== $this->url) {
          // On sauvegarde l'extension du fichier pour le supprimer plus tard
        $this->tempFilename = $this->url;

        // On réinitialise les valeurs des attributs url et alt
        $this->url = null;
        $this->alt = null;
      }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif)
      if (null === $this->file) {
          return;
      }

      // Le nom du fichier est son id, on doit juste stocker également son extension
      // Pour faire propre, on devrait renommer cet attribut en « extension », plutôt que « url »
      $this->url = $this->file->getClientOriginalName();

      // Et on génère l'attribut alt de la balise <img>, à la valeur du nom du fichier sur le PC de l'internaute
      $this->alt = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif)
      if (null === $this->file) {
          return;
      }

      // Si on avait un ancien fichier, on le supprime
      if (null !== $this->tempFilename) {
          $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
          if (file_exists($oldFile)) {
              unlink($oldFile);
          }
      }

//      // On déplace le fichier envoyé dans le répertoire de notre choix
//      $this->file->move(
//      $this->getUploadRootDir(), // Le répertoire de destination
//      $this->id.'.'.$this->url   // Le nom du fichier à créer, ici « id.extension »
//       
//      );
      
    foreach($this->files as $file)
    {
        $url = sha1(uniqid(mt_rand(), true)).'.'.$file->guessExtension();
        array_push ($this->url, $url);
        $file->move($this->getUploadRootDir(), $url);

        unset($file);
    }
    }
    
    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
      $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
      if (file_exists($this->tempFilename)) {
          // On supprime le fichier
        unlink($this->tempFilename);
      }
    }

    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur
      return 'uploads/img';
    }

    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
      return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Set product
     *
     * @param \Entity\EcommerceBundle\Entity\Products $product
     *
     * @return Images
     */
    public function setProduct(\Entity\EcommerceBundle\Entity\Products $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Entity\EcommerceBundle\Entity\Products
     */
    public function getProduct()
    {
        return $this->product;
    }
}
