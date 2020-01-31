<?php

namespace Markup\BarcodeBundle\Factory;

use Imagine\Gd\Image as GdImage;
use Imagine\Image\ImageInterface;
use Imagine\Image\Metadata\MetadataBag;
use Imagine\Image\Palette\RGB;
use Markup\BarcodeBundle\Manager\SharedAccessInterface;
use Zend\Barcode\Barcode as Barcode;
use Zend\Barcode\ObjectPluginManager;
use Zend\Barcode\Renderer\Image as ImageRenderer;

/**
* A wrapper for Zend\Barcode\Barcode::factory() plus draw().
*/
class Factory
{
    /**
     * Creates and draws a barcode (wrapping the Zend Barcode component).
     *
     * @param  mixed    $barcode              String name of barcode class, or Traversable object.
     * @param  mixed    $barcodeConfig        An array or Traversable object with barcode parameters.
     * @param  mixed    $rendererConfig       An array or Traversable object with renderer parameters.
     * @param  boolean  $automaticRenderError Set the automatic rendering of exception
     * @return ImageInterface
     **/
    public function create(
        $barcode,
        $barcodeConfig = [],
        $rendererConfig = [],
        $automaticRenderError = true
    ) {
        $originallySharedByDefault = false;
        $renderer = new ImageRenderer($rendererConfig);
        //make sure Zend object plugin manager does not share created barcode object
        /** @var ObjectPluginManager|SharedAccessInterface $objectPluginManager */
        $objectPluginManager = Barcode::getObjectPluginManager();
        $shouldSupportZf2 = $this->isZf2ServiceManager($objectPluginManager);
        if ($shouldSupportZf2) {
            $originallySharedByDefault = $objectPluginManager->shareByDefault();
            if ($originallySharedByDefault) {
                $objectPluginManager->setShareByDefault(false);
            }
        } else {
            $objectPluginManager->configure(['shared_by_default' => false]);
        }

        $barcodeObject = $objectPluginManager->get($barcode, $barcodeConfig);

        if ($shouldSupportZf2) {
            if ($originallySharedByDefault) {
                //reset object plugin manager
                $objectPluginManager->setShareByDefault(true);
            }
        }

        $renderer->setBarcode($barcodeObject);

        return new GdImage($renderer->draw(), new RGB(), new MetadataBag());
    }

    private function isZf2ServiceManager(ObjectPluginManager $manager)
    {
        return method_exists($manager, 'shareByDefault');
    }
}
