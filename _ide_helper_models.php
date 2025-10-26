<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int|null $user_id
 * @property int $rph_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Rph $rph
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRph newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRph newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRph query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRph whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRph whereRphId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRph whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminRph whereUserId($value)
 */
	class AdminRph extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $previous_hash
 * @property string $current_hash
 * @property array<array-key, mixed> $transaction
 * @property string|null $timestamp
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blockchain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blockchain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blockchain query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blockchain whereCurrentHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blockchain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blockchain wherePreviousHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blockchain whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blockchain whereTransaction($value)
 */
	class Blockchain extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $node
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IoT newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IoT newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IoT query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IoT whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IoT whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IoT whereNode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IoT whereUpdatedAt($value)
 */
	class IoT extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int|null $user_id
 * @property string|null $nomor_sertifikat
 * @property string|null $masa_sertifikat
 * @property string|null $upload_sertifikat
 * @property string|null $waktu_upload
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rph> $rphs
 * @property-read int|null $rphs_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Juleha newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Juleha newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Juleha query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Juleha whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Juleha whereMasaSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Juleha whereNomorSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Juleha whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Juleha whereUploadSertifikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Juleha whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Juleha whereWaktuUpload($value)
 */
	class Juleha extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int|null $user_id
 * @property string|null $no_lapak
 * @property int $pasar_id
 * @property string|null $telp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pasar $pasar
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lapak newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lapak newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lapak query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lapak whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lapak whereNoLapak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lapak wherePasarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lapak whereTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lapak whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lapak whereUserId($value)
 */
	class Lapak extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $alamat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lapak> $lapaks
 * @property-read int|null $lapaks_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasar whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasar whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasar whereUpdatedAt($value)
 */
	class Pasar extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int|null $user_id
 * @property int|null $rph_id
 * @property string|null $nip
 * @property string|null $status
 * @property string|null $tgl_berlaku
 * @property string|null $file_sk
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Rph|null $rph
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penyelia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penyelia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penyelia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penyelia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penyelia whereFileSk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penyelia whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penyelia whereRphId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penyelia whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penyelia whereTglBerlaku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penyelia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penyelia whereUserId($value)
 */
	class Penyelia extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int|null $user_id
 * @property int|null $rph_id
 * @property string|null $status_usaha
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peternak newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peternak newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peternak query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peternak whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peternak whereRphId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peternak whereStatusUsaha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peternak whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peternak whereUserId($value)
 */
	class Peternak extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $alamat
 * @property string|null $phone
 * @property string $status_sertifikasi
 * @property string|null $file_sertifikasi
 * @property string|null $waktu_upload
 * @property int|null $penyelia_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Penyelia|null $penyelia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph whereFileSertifikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph wherePenyeliaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph whereStatusSertifikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rph whereWaktuUpload($value)
 */
	class Rph extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int|null $user_id
 * @property int $access_level
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereAccessLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereUserId($value)
 */
	class SuperAdmin extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $peternak_id
 * @property int|null $juleha_id
 * @property int|null $penyelia_id
 * @property int|null $rph_id
 * @property string|null $img
 * @property float|null $karkas
 * @property string|null $jenis
 * @property string|null $kesehatan
 * @property string|null $waktu_sembelih
 * @property bool|null $validasi_1
 * @property bool|null $validasi_2
 * @property float|null $bobot
 * @property string|null $waktu_daftar
 * @property int|null $no_antri
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $sisa_karkas
 * @property-read \App\Models\Juleha|null $juleha
 * @property-read \App\Models\Penyelia|null $penyelia
 * @property-read \App\Models\Peternak|null $peternak
 * @property-read \App\Models\Transaksi|null $transaksi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereBobot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereJulehaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereKarkas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereKesehatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereNoAntri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak wherePenyeliaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak wherePeternakId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereRphId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereSisaKarkas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereValidasi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereValidasi2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereWaktuDaftar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ternak whereWaktuSembelih($value)
 */
	class Ternak extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $iot_id
 * @property int|null $lapak_id
 * @property int|null $ternak_id
 * @property int|null $rph_id
 * @property float $jumlah
 * @property string $waktu_kirim
 * @property string|null $waktu_selesai_kirim
 * @property string $status_kirim
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\IoT|null $iot
 * @property-read \App\Models\Lapak|null $lapak
 * @property-read \App\Models\Ternak|null $ternak
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereIotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereLapakId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereRphId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereStatusKirim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereTernakId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereWaktuKirim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereWaktuSelesaiKirim($value)
 */
	class Transaksi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone
 * @property string|null $alamat
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

