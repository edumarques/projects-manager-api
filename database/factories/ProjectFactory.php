<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * @inheritdoc
     */
    protected $model = Project::class;


    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'name'         => $this->faker->name,
            'introduction' => $this->faker->paragraph,
            'location'     => $this->faker->address,
            'cost'         => $this->faker->randomFloat(),
        ];
    }

}
