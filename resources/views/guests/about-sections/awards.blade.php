<div class="bg-white dark:bg-gray-900 py-10">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold">Awards & Recognition</h2>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
            Entrade is honored to have received numerous industry awards for innovation, transparency, and service excellence.
        </p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 max-w-6xl mx-auto">
        @foreach ([
            'UF AWARDS MEA' => 'DUBAI, 2024',
            'UF AWARDS GLOBAL' => 'CYPRUS, 2023',
            'UF AWARDS' => 'BANGKOK 2023',
            'FAME AWARD' => 'SA, 2023',
            'UF AWARDS' => 'DUBAI, 2023',
            'UF AWARDS' => 'CYPRUS, 2022',
            'FOREX EXPO' => 'DUBAI, 2022',
        ] as $award => $location)
           

            <div class="relative inline-block">
                <img src="/images/awardLeaf.svg" alt="Award Leaf" class="mx-auto block">
                
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                    <span class="text-base f-14 px-10 font-semibold text-gray-700 dark:text-gray-200">
                        {{ $award }} {{ $location }}
                    </span>
                    <span class="text-base font-semibold text-gray-700 dark:text-gray-200">
                        
                    </span>
        </div>
            </div>


        @endforeach
    </div>
</div>

<!--<section class="blockElement space"><div class="container"><div class="row justify-content-center text-center"><div class="col-12 mb-md-4"><h2>Our <span class="secondary">Awards</span></h2></div><div class="col-12 col-md-4 col-lg-3"><div class="ourAward"><div class="position-relative maskIcon one"><span class="f-14 semibold">UF AWARDS <span>MEA</span></span><span class="f-14 semibold">DUBAI, 2024</span></div><h6 class="f-15">Best Social Trading <span>Solution MEA</span></h6></div></div><div class="col-12 col-md-4 col-lg-3"><div class="ourAward"><div class="position-relative maskIcon one"><span class="f-14 semibold">UF AWARDS <span>GLOBAL</span></span><span class="f-14 semibold">CYPRUS, 2023</span></div><h6 class="f-15">Best Social Trading <span>Solution</span></h6></div></div><div class="col-12 col-md-4 col-lg-3"><div class="ourAward"><div class="position-relative maskIcon"><span class="f-14 semibold">UF AWARDS</span><span class="f-14 semibold">BANGKOK, 2023</span></div><h6 class="f-15">Best Social Trading <span>Solution APAC</span></h6></div></div><div class="col-12 col-md-4 col-lg-3"><div class="ourAward"><div class="position-relative maskIcon"><span class="f-14 semibold">FAME AWARD</span><span class="f-14 semibold">SA, 2023</span></div><h6 class="f-15">Best Wealth <span>Management Platform</span></h6></div></div><div class="col-12 col-md-4 col-lg-3"><div class="ourAward"><div class="position-relative maskIcon"><span class="f-14 semibold">UF AWARDS</span><span class="f-14 semibold">DUBAI, 2023</span></div><h6 class="f-15">Best Social Trading <span>Solution in MEA</span></h6></div></div><div class="col-12 col-md-4 col-lg-3"><div class="ourAward"><div class="position-relative maskIcon"><span class="f-14 semibold">UF AWARDS</span><span class="f-14 semibold">CYPRUS, 2022</span></div><h6 class="f-15">Best Social Trading <span>Solution</span></h6></div></div><div class="col-12 col-md-4 col-lg-3"><div class="ourAward"><div class="position-relative maskIcon"><span class="f-14 semibold">FOREX EXPO</span><span class="f-14 semibold">DUBAI, 2022</span></div><h6 class="f-15">Best Social Wealth <span>Management Platform</span></h6></div></div></div></div></section>-->

