<?php

namespace App\Characters;

use App\ManagedFile;
use App\User;
use App\Comics\Comic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Character
 *
 * @property integer $id
 * @property string $name
 * @property string $gender
 * @property string $height
 * @property string $weight
 * @property string $bio
 * @property \App\Type $type
 * @property \App\CharacterStatus $status
 * @property string $icon_id
 * @property string $design_sheet_id
 * @property integer $intro_id
 * @property string $intro_id_legacy
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $creators
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comic[] $comics
 * @property-read \App\ManagedFile $icon
 * @property-read \App\ManagedFile $design_sheet
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ManagedFile[] $supplementary_art
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereBio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereIconId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereDesignSheetId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereIntroId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereIntroIdLegacy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Character whereDeletedAt($value)
 * @mixin \Eloquent
 * @property integer $type_id
 * @property integer $status_id
 * @property-read \App\ManagedFile $designSheet
 * @property-read \App\Comics\Comic $intro
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ManagedFile[] $supplementaryArt
 * @method static \Illuminate\Database\Query\Builder|\App\Characters\Character whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Characters\Character whereStatusId($value)
 */
class Character extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gender',
        'height',
        'weight',
        'bio',
        'type_id',
        'status_id',
        'icon_id',
        'design_sheet_id',
        'intro_id',
    ];

    protected $with = [
        'type',
        'status',
        'icon',
    ];

    /**
     * Get the character icon.
     */
    public function type()
    {
        return $this->belongsTo(CharacterType::class);
    }

    /**
     * Get the character icon.
     */
    public function status()
    {
        return $this->belongsTo(CharacterStatus::class);
    }

    /**
     * The users ("creators") attached to this character.
     */
    public function creators()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The comics attached to this character.
     */
    public function comics()
    {
        return $this->belongsToMany(Comic::class);
    }

    /**
     * Get the character icon.
     * Fun Fact: This works opposite of how morphOne would normally work, because it uses
     * characters.icon_id = files_managed.id instead of files_managed.attacher_id = characters.id
     */
    public function icon()
    {
        return $this->belongsTo(ManagedFile::class);
    }

    /**
     * Get the character icon.
     */
    public function designSheet()
    {
        return $this->belongsTo('App\ManagedFile');
    }

    public function intro()
    {
        return $this->belongsTo('App\Comics\Comic');
    }

    /**
     * Get all of the character's supplementary art.
     */
    public function supplementaryArt()
    {
        return $this->belongsToMany('App\ManagedFile', 'character_supplementary_art');
    }

    public function saveWithRelations($data = [])
    {
        $this->fill($data);

        // CharacterType
        if ($type_id = $data['type_id'] ?? $data['type']['id'] ?? null) {
            $this->type()->associate(CharacterType::findOrFail($type_id));
        }

        // CharacterStatus
        if ($status_id = $data['status_id'] ?? $data['status']['id'] ?? null) {
            $this->status()->associate(CharacterStatus::findOrFail($status_id));
        }

        // Creators (User)
        if (array_key_exists('creators', $data)) {
            $this->creators()->sync(map($data['creators'], function($creator) {
                $id = null;
                if (is_numeric($creator)) {
                    $id = $creator;
                } elseif (is_array($creator) && array_key_exists('id', $creator)) {
                    $id = $creator['id'];
                }
                return User::findOrFail($id);
            }));
        }

        // Intro (Comic)
        if (array_key_exists('intro', $data)) {
            if (array_key_exists('id', $data['intro'])) {
                $intro = Comic::findOrFail($data['intro']['id']);
            } else {
                $intro = Comic::create($data['intro']);
            }
            $this->intro()->associate($intro);
        } elseif (array_key_exists('intro_id', $data)) {
            $this->intro()->associate(Comic::findOrFail($data['intro_id']));
        }

        // Icon (ManagedFile)
        if (array_key_exists('icon', $data)) {
            if (array_key_exists('id', $data['icon'])) {
                $icon = ManagedFile::findOrFail($data['icon']['id']);
            } else {
                $icon = ManagedFile::create($data['icon']);
            }
            $this->icon()->associate($icon);
        } elseif (array_key_exists('icon_id', $data)) {
            $this->icon()->associate(ManagedFile::findOrFail($data['icon_id']));
        }

        // Design Sheet (ManagedFile)
        if (array_key_exists('design_sheet', $data)) {
            if (array_key_exists('id', $data['design_sheet'])) {
                $designSheet = ManagedFile::findOrFail($data['design_sheet']['id']);
            } else {
                $designSheet = ManagedFile::create($data['design_sheet']);
            }
            $this->designSheet()->associate($designSheet);
        } elseif (array_key_exists('design_sheet_id', $data)) {
            $this->designSheet()->associate(ManagedFile::findOrFail($data['design_sheet_id']));
        }

        // Supplementary Art (ManagedFile)
        if (array_key_exists('supplementary_art', $data)) {
            $this->supplementaryArt()->sync(filter(map($data['supplementary_art'], function($supplementaryArt) {
                $id = null;
                if (is_numeric($supplementaryArt)) {
                    $id = $supplementaryArt;
                } elseif (is_array($supplementaryArt) && array_key_exists('id', $supplementaryArt)) {
                    $id = $supplementaryArt['id'];
                }
                if (!$id && is_array($supplementaryArt)) {
                    return ManagedFile::create($supplementaryArt)->id;
                } else {
                    return ManagedFile::findOrFail($id)->id;
                }
            })));
        }

        return $this->save();
    }
}
