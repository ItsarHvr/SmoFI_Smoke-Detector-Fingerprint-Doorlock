<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Door
 *
 * @property int $id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Door newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Door newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Door query()
 * @method static \Illuminate\Database\Eloquent\Builder|Door whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Door whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Door whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Door whereUpdatedAt($value)
 */
	class Door extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FingerData
 *
 * @property int $fingerprint_id
 * @property string $access
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|FingerData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FingerData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FingerData query()
 * @method static \Illuminate\Database\Eloquent\Builder|FingerData whereAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FingerData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FingerData whereFingerprintId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FingerData whereUpdatedAt($value)
 */
	class FingerData extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GasReading
 *
 * @property int $id
 * @property int $gas_value
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GasReading newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GasReading newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GasReading query()
 * @method static \Illuminate\Database\Eloquent\Builder|GasReading whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GasReading whereGasValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GasReading whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GasReading whereUpdatedAt($value)
 */
	class GasReading extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LogAccess
 *
 * @property int $id
 * @property string $user_name
 * @property string $fingerprint_id
 * @property string $access_date
 * @property string $access_time
 * @property string $access
 * @method static \Illuminate\Database\Eloquent\Builder|LogAccess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogAccess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogAccess query()
 * @method static \Illuminate\Database\Eloquent\Builder|LogAccess whereAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogAccess whereAccessDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogAccess whereAccessTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogAccess whereFingerprintId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogAccess whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogAccess whereUserName($value)
 */
	class LogAccess extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Mahasiswa
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Mahasiswa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mahasiswa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mahasiswa query()
 */
	class Mahasiswa extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RelayStatus
 *
 * @property int $id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RelayStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RelayStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RelayStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|RelayStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RelayStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RelayStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RelayStatus whereUpdatedAt($value)
 */
	class RelayStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Siswa
 *
 * @property int $id
 * @property string $nama
 * @property string $kelas
 * @property string $nim
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa query()
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereNim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereUpdatedAt($value)
 */
	class Siswa extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property int|null $fingerprint_id
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FingerData|null $fingerData
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFingerprintId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

