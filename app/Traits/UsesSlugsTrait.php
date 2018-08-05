<?php

namespace App\Traits;

trait UsesSlugsTrait
{
    /**
     * The column on the on the model that slug saved to.
     *
     * @var string
     */
    protected static $slugColumn = 'slug';

    /**
     * The attribute on the on the model that slug is derived from.
     *
     * @var string
     */
    protected static $slugFrom = '';

    // Boot this trait
    public static function bootUsesSlugsTrait()
    {
        // add event to model to automatically create slugs
        static::saving(function ($model) {

            if($model->{static::$slugColumn}){   //check whether there is slug attached
                //Slug equals to attached value
                $slug = $model->{static::$slugColumn};
                $slug = static::formatSlug($slug);
            }else{ //if no slug, create one
                $slug = static::createSlug($model);
            }

            //check and make slug unique
            $slug = static::uniqueSlug($model, $slug);

            //set slug
            $model->{static::$slugColumn} = $slug;

            return true;

        });
    }

    public static function findBySlug($slug)
    {
        return static::where(static::$slugColumn, $slug)->first();
    }

    public static function queryBySlug($slug)
    {
        return static::where(static::$slugColumn, $slug);
    }

    public function getSlug()
    {
        return $this->{static::$slugColumn};
    }

    public static function createSlug($model)
    {
        // try guess field name for making slug from
        $slugFrom = static::$slugFrom;
        if (static::$slugFrom == "") {

            // usually called name or title
            if ($model->name !== NULL) $slugFrom = 'name';
            elseif ($model->title !== NULL) $slugFrom = 'title';
            else {
                abort(500, 'Using UsesSlugTrait on model without defined attribute to derive slug from.');
            }

            if (strlen(trim($model->$slugFrom)) == 0) {
                $model->$slugFrom = 'empty';
            }

        }
            $slug = static::formatSlug(trim($model->$slugFrom));

        return $slug;
    }

    public static function uniqueSlug($model, $slug){
        $class = static::class;
        $new_slug = $slug;

        // check if updating existing model, if has key and slug already matches move on!
        if ($model->getKey() !== NULL && $slug == $model->{static::$slugColumn}) {
            // check this model not already have a duplicate slug (apart from itself)
            if (forward_static_call([$class, 'where'], static::$slugColumn, $slug)
                    ->where($model->getKeyName(), '!=', $model->getKey())
                    ->count() == 0) {
                // all good, save and move on
                return $new_slug;
            }
        }

        // now check if slug is unique
        $c = 2;
        while (forward_static_call([$class, 'where'], static::$slugColumn, $new_slug)
                ->count() > 0) {
            // not unique, just add number for next
            //echo "hit none unique " . $slug . '  -  '. $c;
            $new_slug = $slug . '-' . $c;
            // and check again after incrementing c
            $c++;
        }

        return $new_slug;
    }

    public static function formatSlug($slug){
        // now make the slug - remove all non-alphanumerics (understand unicode though) and any
        // whitespace, tabs, newlines replaced to just a single space which is then changed to hyphen
        // finally make all lower case using unicode safe
        $slug = preg_replace('/-[^\p{L}\p{Nd}\040\t\n\r]+/', '', trim($slug));
        $slug = preg_replace(['/\s{2,}/', '/[\t\n]/'], ' ', $slug);
        $slug = str_replace(' ', '-', $slug);
        $slug = mb_strtolower($slug, 'UTF-8');
        $slug = str_replace('?', '', $slug);
        $slug = str_replace('--', '-', $slug);

        return $slug;
    }
}