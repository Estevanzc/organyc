# General Notes

## about the view files

Every file endpoint in views must have its name ending with ".blade.php" to allow it to be founded by the laravel routes
oxford-blue: #0a1128ff;
penn-blue: #001f54ff;
indigo-dye: #034078ff;
cerulean: #1282a2ff;
white: #fefcfbff;

yale-blue: #134074ff;
berkeley-blue: #13315cff;
oxford-blue: #0b2545ff;
powder-blue: #8da9c4ff;
mint-cream: #eef4edff;

## laravel crud

### important commands

#### start server
    php artisan serve

#### create or refresh the database
    php artisan migrate
    php artisan migrate:fresh
    php artisan migrate:rollback //retorna à ultima alteração de banco
    php artisan make:migration add_alert_to_notes_table //alter the table addin fields

#### install all the dependecies
    composer install

#### create new project (it only works on empty dir) (already done)
    composer create-project laravel/laravel .

#### create table, controller, models
    php artisan make:migration create_(table_name - needs to be lowerCase and in plural)_table
    php artisan make:controller PostController //any name you want
    php artisan make:model Post //it will only work if the table name match to the rules right above
    php artisan make:model Product -cm //will create model, controller and migration based on this name (needs to be singual and and camel_case)

#### how to manually insert data in a table
##### user laravel tinker
    php artisan tinker

##### with the tinker opened, use the common commands
    use App\Models\{model_name};
    Ong_type::create([
        "field_name" => "field_value"
    ]) //used to single inserts
    Ong_type::insert([
        ["field_name" => "field_value"],
        ["field_name" => "field_value"],
        ["field_name" => "field_value"],
        ["field_name" => "field_value"],
    ]) //used to insert in series

### Seeder

    php artisan make:seeder NoteSeeder //cria uma seeder da tabela
    php artisan db:seed //seed the db with the seeders data (before making the steps rith bellow)
    php artisan migrate:fresh --seed //restart the db data from scratch and auto seed
    php artisan db:seed --class=UseSeeder //run a scpecific seeder

#### Seeder data

    public function run(): void {
        DB::table("notes")->insert([
            [
                "title" => "teste",
                "texto" => "teste",
            ],
            [
                "title" => "teste1",
                "texto" => "teste1",
            ]
        ]);
    }

### change laravel error lang

    composer require laravel-lang/lang --dev
    php artisan lang:add pt

### change lang

    composer require lucascudo/laravel-pt-br-localization --dev
    php artisan lang:publish //extract lang from vendor
    php artisan vendor:publish --tag=laravel-pt-br-localization


### breeze

it is a authentication laravel library

    composer require laravel/breeze --dev
    php artisan breeze:install

### policy

    php artisan make:policy MembroPolicy --model=Membro //should be true as default

### generate db key

    composer install
    php artisan key:generate
    php artisan migrate --seed

# APIs

## Consulta Taxonômica e informações classificatórias:

> https://api.iucnredlist.org/api-docs/index.html
`Fhc6oLwy3nXfpXZNPYFToLNstXNTGtJ9oHj2`

## Dados gerais e imagens:

> https://api.inaturalist.org/v1/taxa?q=Panthera%20leo

## APIs para plantas

> https://perenual.com/docs/plant-open-api#/
`sk-Jaho68c4c4525388112349`


## APIs para animais

https://api-ninjas.com/api/animals

`ZOuaMCrn60TxdcTBNSE3Wg==TDcSvx1ca3BeHQPI`

https://api.api-ninjas.com/v1/animals?name=cheetah&X-Api-Key=ZOuaMCrn60TxdcTBNSE3Wg==TDcSvx1ca3BeHQPI

### Gbif (animais e plantas)
> https://techdocs.gbif.org/en/openapi/v1/species#/

#### dados gerais: taxonomia, ancestral, número de decendentes
> https://api.gbif.org/v1/species/5231190/

#### busca por nome científico
> https://api.gbif.org/v1/species/match?name=Tulipa%20linifolia

#### nomes vernaculares
> https://api.gbif.org/v1/species/5299508/vernacularNames

#### categoria de extinção
> https://api.gbif.org/v1/species/5299508/iucnRedListCategory

#### localidades
> https://api.gbif.org/v1/species/5231190/distributions

#### habitats, mobilidade e expectativa de vida
> https://api.gbif.org/v1/species/5231190/descriptions


### inaturalist

### página wikipedia, imagem, ancestrais
> https://api.inaturalist.org/v1/taxa?q=Panthera%20leo




wXfcRsfmO2oejfPAyyWsslb-eoMw0_5ak-1Ngv3HonEuJcC7McZs5R3eJQFo8uVhAable3dleWrlDeRlGxo2XUmRcfOXWp1-4UKU0NJYMajXySSYL0f8TWGrGUZXxyXUvZpg_rOEvSkKL2BG1AOvlv3uE8S5iryUMrrmXgF1MZ4=