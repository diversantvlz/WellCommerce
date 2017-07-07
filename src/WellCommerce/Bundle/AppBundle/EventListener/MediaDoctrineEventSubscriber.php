<?php

namespace WellCommerce\Bundle\AppBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Symfony\Component\Filesystem\Filesystem;
use WellCommerce\Bundle\AppBundle\Entity\Media;
use WellCommerce\Bundle\AppBundle\Service\Media\Uploader\MediaUploaderInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class MediaDoctrineEventSubscriber implements EventSubscriber
{
    protected $mediaUploadDir;
    protected $filesystem;

    public function __construct(Filesystem $filesystem, string $mediaUploadDir)
    {
        $this->filesystem = $filesystem;
        $this->mediaUploadDir = $mediaUploadDir;
    }

    public function getSubscribedEvents()
    {
        return [
            'postPersist',
            'postUpdate',
            'preRemove'
        ];
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->onPostDataUpdate($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->onPostDataUpdate($args);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $media = $args->getEntity();

        if ($media instanceof Media) {
            $file = $this->mediaUploadDir . $media->getPath();
            if ($this->filesystem->exists($file)) {
                $this->filesystem->remove($file);
            }
        }
    }

    protected function onPostDataUpdate(LifecycleEventArgs $args)
    {
        $media = $args->getEntity();

        if ($media instanceof Media) {
            $tmpFile = $media->getTmpFile();

            if ($tmpFile) {
                $tmpFile->move($this->mediaUploadDir, $media->getPath());
                $media->resetTmpFile();
            }
        }
    }
}