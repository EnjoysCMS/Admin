<?php


namespace App\Module\Admin\Components\DBAL;


use EnjoysCMS\Core\Components\Doctrine\EnumType;

class EnumSettingAllowedType extends EnumType
{
    protected $name = 'allowedSettingType';
    protected $values = ['text', 'select', 'textarea', 'radio'];
}
