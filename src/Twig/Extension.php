<?php

namespace App\Twig;

use App\Twig\GenerateClass\GenerateClass;
use Symfony\Component\Translation\Translator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Extension extends AbstractExtension
{
    public const DOMAIN = "ppe";

    public static string $template;
    public static string $typeTemplate;

    public Translator $trans;

    public function __construct()
    {
        $this->trans = new Translator("fr");
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): iterable
    {
        return [
            new TwigFunction('initTemplate', [GenerateClass::class, 'initTemplate']),
            new TwigFunction('generateClass', [GenerateClass::class, 'generateClass'])
        ];
    }

    /**
     * @param string $string
     * @param array $param
     * @param string $domain
     * @return string
     */
    public function translatedString(string $string, array $param = [], string $domain = self::DOMAIN) : string
    {
        return $this->trans->trans($string, $param, $domain);
    }
}