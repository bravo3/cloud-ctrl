<?php
namespace Bravo3\CloudCtrl\Enum;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * @method static ImageState AVAILABLE()
 * @method static ImageState PENDING()
 * @method static ImageState DEREGISTERED()
 */
final class ImageState extends AbstractEnumeration
{
    const AVAILABLE    = 'AVAILABLE';
    const PENDING      = 'PENDING';
    const DEREGISTERED = 'DEREGISTERED';
}
