<?php


namespace App\Model;


class CultureFeiyiMingluEntity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'culture_feiyi_minglu_entities';

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'default';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "fy_type",
        "code",
        "title",
        "jibie",
        "lei_bie",
        "feiyi_bianhao",
        "gongbu_shijian",
        "pi_ci",
        "shenbao_diqu_danwei",
        "baohu_danwei",
        "province_title",
        "city_title",
        "district_title",
        "pos_x",
        "pos_y",
        "hai_ba",
        "title_alias",
        "min_zu",
        "chao_dai",
        "yuan_liu",
        "shishu_dianji",
        "chuan_cheng_ren",
        "chuan_cheng_fangshi",
        "wenhua_gongneng",
        "tu_teng",
        "tu_xing",
        "yue_qi",
        "shuochang_xingshi",
        "wu_dao",
        "zong_jiao",
        "shen_zhi",
        "shi_jie",
        "description",
        "image_cover",
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer'];
}