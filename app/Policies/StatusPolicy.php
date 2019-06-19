<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * 删除微博授权策略
 * Class StatusPolicy
 * @package App\Policies
 */
class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * 当前用户是微博的创建者才可以删除
     * @param User $user
     * @param Status $status
     * @return bool
     */
    public function destroy(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }
}
