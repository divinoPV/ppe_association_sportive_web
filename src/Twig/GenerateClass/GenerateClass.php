<?php

namespace App\Twig\GenerateClass;

use App\Twig\Extension;
use Twig\Extension\RuntimeExtensionInterface;

class GenerateClass extends Extension implements RuntimeExtensionInterface
{
    public function initTemplate(string $template, string $typeTemplate): void
    {
        self::$template = $template;
        self::$typeTemplate = $typeTemplate;
    }

    public function generateClass(string $class, ?string $typeTemplate = null, ?string $template = null): string
    {
        if (!empty($class)):

            if (!empty($template) && !empty($typeTemplate)):
                return $this->generateClassString($class, $typeTemplate, $template);
            elseif (!empty($template) && empty($typeTemplate)):

                if (!empty(self::$typeTemplate)):
                    return $this->generateClassString($class, self::$typeTemplate, $template);
                else:
                    return $this->translatedString("Vous devez saisir le type de template !");
                endif;

            elseif (empty($template) && !empty($typeTemplate) && !empty(self::$template)):

                if (!empty(self::$typeTemplate)):
                    return $this->generateClassString($class, $typeTemplate, self::$template);
                else:
                    return $this->translatedString("Vous devez saisir le nom du template !");
                endif;

            elseif (empty($template) && empty($typeTemplate)):

                if (!empty(self::$template) && !empty(self::$typeTemplate)):
                    return $this->generateClassString($class, self::$typeTemplate, self::$template);
                else:
                    return $this->translatedString("Vous devez saisir le nom du template et le type de template !");
                endif;

            else:
                return $this->generateClassString($class, $typeTemplate, $template);
            endif;

        else:
            return $this->translatedString("Vous devez saisir le nom de la classe !");
        endif;
    }

    public function generateClassString(string $class, string $typeTemplate, string $template): string
    {
        return $class . " $class-" . $typeTemplate . " $class-" . $typeTemplate . '-' . $template;
    }
}