<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $menu = [
            [
                'seq_no' => 1,
                'name' => 'Dashboard',
                'route' => 'dashboard',
                'image' => 'fa-solid fa-house',
            ],
            // audio_lectures, fa-file-audio
            [
                'seq_no' => 2,
                'name' => 'Audio Lectures',
                'route' => 'audio_lectures',
                'image' => 'fa-file-audio',
            ],
            // campaigns, fa-folder-plus
            [
                'seq_no' => 3,
                'name' => 'Campaigns',
                'route' => 'campaigns',
                'image' => 'fa-folder-plus',
            ],
            // books_library, fa-book-open
            [
                'seq_no' => 4,
                'name' => 'Books Library',
                'route' => 'books_library',
                'image' => 'fa-book-open',
            ],
            // blogs, fa-blog
            [
                'seq_no' => 5,
                'name' => 'Blogs',
                'route' => 'blogs',
                'image' => 'fa-blog',
            ],
            // gallery, fa-images
            [
                'seq_no' => 6,
                'name' => 'Gallery',
                'route' => 'gallery',
                'image' => 'fa-images',
            ],
            // courses, fa-user-graduate
            [
                'seq_no' => 7,
                'name' => 'Courses',
                'route' => 'courses',
                'image' => 'fa-user-graduate',
            ],
            // news_events, fa-newspaper
            [
                'seq_no' => 8,
                'name' => 'News & Events',
                'route' => 'news_events',
                'image' => 'fa-newspaper',
            ],
            // irm_settings, fa-gear
            [
                'seq_no' => 9,
                'name' => 'Settings',
                'route' => 'irm_settings',
                'image' => 'fa-gear',
            ],
            // payments, fa-money-bill-1
            [
                'seq_no' => 10,
                'name' => 'Payments',
                'route' => 'payments',
                'image' => 'fa-money-bill-1',
            ],
            // bookorders, fa-book
            [
                'seq_no' => 11,
                'name' => 'Book Orders',
                'route' => 'bookorders',
                'image' => 'fa-book',
            ],
            // enrollCourses, fa-hard-drive
            [
                'seq_no' => 12,
                'name' => 'Enroll Courses',
                'route' => 'enrollCourses',
                'image' => 'fa-hard-drive',
            ],
            // viewContact, fa-id-card-clip
            [
                'seq_no' => 13,
                'name' => 'View Contact',
                'route' => 'viewContact',
                'image' => 'fa-id-card-clip',
            ],
            // memberships, fa-address-card
            [
                'seq_no' => 14,
                'name' => 'Memberships',
                'route' => 'memberships',
                'image' => 'fa-address-card',
            ],
            // youtube, fa-youtube
            [
                'seq_no' => 15,
                'name' => 'Youtube',
                'route' => 'youtube',
                'image' => 'fa-youtube',
            ],
            // worklocation,  fa-map-marker
            [
                'seq_no' => 16,
                'name' => 'Work Location',
                'route' => 'worklocation',
                'image' => 'fa-map-marker',
            ],
            // sub-admins, fa-user-secret
            [
                'seq_no' => 17,
                'name' => 'Sub Admins',
                'route' => 'sub-admins',
                'image' => 'fa-user-secret',
            ],
            // joinUs, fa-user-plus
            [
                'seq_no' => 18,
                'name' => 'Join Us',
                'route' => 'joinUs',
                'image' => 'fa-user-plus',
            ],
        ];
        // insert data
        DB::table('menus')->insert($menu);
    }
}
