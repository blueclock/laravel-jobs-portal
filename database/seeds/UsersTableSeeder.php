<?php

use App\Entities\Job;
use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Entities\Company;

class UsersTableSeeder extends Seeder
{
    protected  $faker;

    /**
     * UsersTableSeeder constructor.
     * @param $faker
     */
    public function __construct(Faker\Generator $faker)
    {
        $this->faker = $faker;
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = $this->faker;

        factory(User::class, 50)->create()
            ->each(function($user) use ($faker){
                $jobseeker  = $user->jobseeker()->save(factory(\App\Entities\Jobseeker::class)->make());
                $resume     = $jobseeker->resumes()->save(factory(\App\Entities\Resume::class)->make());
                $resume->studies()->saveMany(factory(\App\Entities\Study::class, 2)->make());
                $resume->experiences()->saveMany(factory(\App\Entities\Experience::class, 2)->make());
                $resume->skills()->sync($faker->randomElements([1,2,3,4,5,6,7,8,9,10], 3));
            });

        factory(User::class, 'employer', 5)
            ->create()
            ->each(function($user) {
                $company = $user->companies()->save(factory(Company::class)->make());
                $company->jobs()->saveMany(factory(Job::class, 15)->make());
            });
    }
}
