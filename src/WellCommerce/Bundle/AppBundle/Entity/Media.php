<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\AppBundle\Entity;

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Symfony\Component\HttpFoundation\File\File;
use WellCommerce\Bundle\CoreBundle\Doctrine\Behaviours\Identifiable;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;

/**
 * Class Media
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Media implements EntityInterface
{
    use Identifiable;
    use Timestampable;
    use Blameable;
    
    protected $name      = '';
    protected $path      = '';
    protected $extension = '';
    protected $mime      = '';
    protected $size      = 0;
    protected $checksum  = null;

    /**
     * @var null|File
     */
    protected $tmpFile = null;

    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getPath(): string
    {
        return $this->path;
    }
    
    public function setPath(string $path)
    {
        $this->path = $path;
    }
    
    public function getMime(): string
    {
        return $this->mime;
    }
    
    public function setMime(string $mime)
    {
        $this->mime = $mime;
    }
    
    public function getSize(): int
    {
        return $this->size;
    }
    
    public function setSize(int $size)
    {
        $this->size = $size;
    }
    
    public function getFullName(): string
    {
        return sprintf('%s.%s', $this->id, $this->extension);
    }
    
    public function getExtension(): string
    {
        return $this->extension;
    }
    
    public function setExtension(string $extension)
    {
        $this->extension = $extension;
    }
    
    public function preUpload()
    {
        if (null !== $this->getExtension()) {
            $filename   = sha1($this->name);
            $this->path = sprintf('%s.%s', $filename, $this->getExtension());
        }
    }

    public function getChecksum()
    {
        return $this->checksum;
    }

    public function getTmpFile()
    {
        return $this->tmpFile;
    }

    public function setTmpFile(File $tmpFile)
    {
        if($tmpFile->isFile()){
            $this->checksum = md5_file($tmpFile->getPathname());
            $this->tmpFile = $tmpFile;
        }
    }

    public function resetTmpFile(){
        $this->tmpFile = null;
    }
}
