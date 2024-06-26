<?php

namespace App\Models;

use App\Casts\ImageCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    public $timestamps = false;

    protected $primaryKey = "ART_CODE";

    protected $table = 'ARTICLES';

    protected $keyType = 'string';

    protected $fillable = [
        'ART_CODE',
        'ART_LIB',
        'ART_TGAMME',
        'ART_DORT',
        'FAR_CODE',
        'ART_FARNAT',
        'SFA_CODE',
        'ART_SFANAT',
        'ART_TYPE',
        'ART_CATEG',
        'ART_QTEDFT',
        'ART_PRIXAU',
        'ART_T_APP',
        'ART_F_APP',
        'ART_T_APP2',
        'ART_F_APP2',
        'ART_T_APP3',
        'ART_F_APP3',
        'ART_T_ACH',
        'ART_F_ACH',
        'ART_T_ACH2',
        'ART_F_ACH2',
        'ART_T_ACH3',
        'ART_F_ACH3',
        'ART_M_PRV',
        'ART_I_PRV',
        'ART_V_ARR',
        'ART_T_ARR',
        'ART_REMMAX',
        'ART_RMXDOC',
        'ART_TRENDU',
        'ART_FRENDU',
        'ART_P_ACH',
        'ART_P_PRV',
        'ART_P_COEF',
        'ART_P_VTEB',
        'ART_P_VTE',
        'ART_P_EURO',
        'ART_LIBC',
        'ART_CBAR',
        'ART_REF',
        'ART_NII',
        'ART_MFACT',
        'ART_MACHAT',
        'ART_DELAI',
        'ART_CONSIG',
        'GAR_CODE',
        'FA1_CODE',
        'FA2_CODE',
        'FA3_CODE',
        'FA4_CODE',
        'FA5_CODE',
        'ART_NIMP',
        'ART_NSTAT',
        'ART_NCOM',
        'ART_CONTRM',
        'ART_INTV',
        'ART_INTA',
        'ART_MSUPPTPF1',
        'ART_MSUPPTPF2',
        'ART_UC_ACH',
        'ART_CD_ACH',
        'ART_UB_ACH',
        'ART_UC_STK',
        'ART_CD_STK',
        'ART_UB_STK',
        'ART_UC_VTE',
        'ART_CD_VTE',
        'ART_UB_VTE',
        'ART_R_UAUV',
        'ART_R_USUV',
        'ART_NCOLIS',
        'ART_POIDSN',
        'ART_POIDST',
        'ART_POIDSB',
        'ART_LONG',
        'ART_LARG',
        'ART_HAUT',
        'ART_VOLUME',
        'ART_PACHUB',
        'ART_PVTEUB',
        'ART_PV_MAN',
        'ART_STOCK',
        'ART_TLOT',
        'ART_LCSNSH',
        'ART_PERIMA',
        'ART_DELCOM',
        'ART_S_PRV',
        'ART_D_PRV',
        'ART_GROUPE',
        'ART_REMPL',
        'ART_AUCFS',
        'ART_MEMO',
        'ART_AFFMES',
        'ART_MESSAG',
        'ART_IMAGE',
        'ART_FMTIMG',
        'ART_DTCREE',
        'ART_USRCRE',
        'ART_DTMAJ',
        'ART_USRMAJ',
        'ART_NUMMAJ',
        'ART_OLDCOD',
        'ART_RENPAR',
        'ART_RENLE',
        'PCF_CODE',
        'XXX_CLI',
        'XXX_MAT',
        'XXX_NSERIE',
    ];

    protected $casts = [
        "ART_IMAGE" => ImageCast::class
    ];

//    protected $appends = ['sameFamilyAvailable'];

    public function sameFamilyAvailable(): Attribute
    {
        return Attribute::make(
            get: fn () => Article::query()->where('FAR_CODE', $this->FAR_CODE)->where('ART_CODE', '!=', $this->ART_CODE)->exists(),
        );
    }

    public function paniers(): HasMany
    {
        return $this->hasMany(Panier::class, 'ART_CODE', 'ART_CODE');
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'ART_CODE', 'ART_CODE');
    }
}
