<?php

namespace App\Policies;

use App\Model\Admin\Admin;
use App\Model\Admin\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view the post.
     *
     * @param  \App\Model\Admin\Admin  $admin
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(Admin $admin, Post $post)
    {
        //
    }

    /**
     * Determine whether the admin can create posts.
     *
     * @param  \App\Model\Admin\Admin  $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        foreach ($admin->roles as $role) {
            foreach ($role->permissions as $permission) {
                if ($permission->id == 1) {
                   return true;
                }else{
                    return false;
                }
            }
        }
    }

    /**
     * Determine whether the admin can update the post.
     *
     * @param  \App\Model\Admin\Admin  $admin
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(Admin $admin, Post $post)
    {
        //
    }

    /**
     * Determine whether the admin can delete the post.
     *
     * @param  \App\Model\Admin\Admin  $admin
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(Admin $admin, Post $post)
    {
        //
    }
}
