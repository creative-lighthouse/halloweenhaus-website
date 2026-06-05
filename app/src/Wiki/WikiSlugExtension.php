<?php

namespace App\Wiki;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;

/**
 * Class \App\Wiki\WikiSlugExtension
 *
 * @property Artefact|Character|Location|MediaProject|Show|WikiSlugExtension $owner
 * @property ?string $URLSlug
 */
class WikiSlugExtension extends Extension
{
    private static $db = [
        'URLSlug' => 'Varchar(255)',
    ];

    public function onBeforeWrite()
    {
        if (!$this->owner->URLSlug) {
            $this->owner->URLSlug = $this->generateUniqueSlug($this->owner->Title);
        }
    }

    public function updateCMSFields(FieldList $fields)
    {
        $slugField = $fields->dataFieldByName('URLSlug');
        if ($slugField) {
            $slugField->setDescription(
                'URL-Slug für diesen Eintrag. Wird automatisch aus dem Titel generiert wenn leer. ' .
                'Achtung: Änderungen brechen bestehende Links und Lesezeichen!'
            );
        }
    }

    private function generateUniqueSlug(string $title): string
    {
        $base = self::slugify($title);
        $slug = $base;
        $i = 2;

        while ($this->slugExists($slug)) {
            $slug = $base . '-' . $i;
            $i++;
        }

        return $slug;
    }

    private function slugExists(string $slug): bool
    {
        return $this->owner::get()
            ->filter('URLSlug', $slug)
            ->exclude('ID', $this->owner->ID ?: 0)
            ->exists();
    }

    public static function slugify(string $title): string
    {
        $map = [
            'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue',
            'Ä' => 'ae', 'Ö' => 'oe', 'Ü' => 'ue',
            'ß' => 'ss',
        ];
        $slug = strtr($title, $map);
        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        return trim($slug, '-') ?: 'eintrag';
    }
}
