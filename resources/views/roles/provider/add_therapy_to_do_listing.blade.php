@production
                @php
                    $__defaults = [
                        'title'        => old('title'),
                        'description' => old('description'),
                        'method' => old('method'),
                        'duration' => old('duration'),
                        'material' => old('material'),
                    ];
                @endphp
            @else
                @php
                    $faker = Faker\Factory::create();
                    $__defaults = [
                        'title'        => ucfirst($faker->words(random_int(2, 4), true)),
                        'description' => ucfirst($faker->sentences(random_int(2, 5), true)),
                        'method' => ucfirst($faker->sentences(random_int(2,5),true)),
                        'duration'      => time(),
                        'material'   => ucfirst($faker->sentences(random_int(2,5),true)),
                        'image'      => $faker->imageUrl(640, 480, 'technics', true),
                        
                    ];
                @endphp
            @endproduction
<x-dashboard.widgets.form.input
                label="Title"
                name="title"
                id="listingTitle"
                value="{{ $__defaults['title'] }}"
                placeholder="Enter therapy name"
                required
            />
            <x-dashboard.widgets.form.input
                label="Description"
                name="description"
                id="listingDescription"
                value="{{ $__defaults['description'] }}"
                placeholder="Enter therapy description"
                required
            />  
            <x-dashboard.widgets.form.input
                label="Start"
                name="start"
                id="listingStart"
                value="{{ $__defaults['method'] }}"
                placeholder="Enter start date"
                required
            />