<?php

namespace Database\Seeders;

use App\Models\Levels_products;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {

    $this->call(DenominationSeeder::class);
    $this->call(CategorySeeder::class);
    $this->call(MeatcutSeeder::class);
    $this->call(UnitofmeasureSeeder::class);
    $this->call(Levels_productSeeder::class);
    $this->call(ProductSeeder::class);
    $this->call(UserSeeder::class);
    $this->call(Type_identificationSeeder::class);
    $this->call(Type_regimen_ivaSeeder::class);
    $this->call(OfficeSeeder::class);
    $this->call(ProvinceSeeder::class);
    $this->call(AgreementSeeder::class); 
    $this->call(ThirdSeeder::class);
    $this->call(Precio_agreementSeeder::class);
    $this->call(SacrificioSeeder::class);
      
    $this->call(SacrificiocerdoSeeder::class);
    $this->call(SacrificiospolloSeeder::class);
    // $this->call(BeneficiocerdoSeeder::class);          
    // $this->call(DespostereSeeder::class);
    $this->call(CentrocostoSeeder::class);    
      $this->call(BeneficioreSeeder::class);
    $this->call(Centro_costo_productSeeder::class);
    $this->call(Nicho_mercadoSeeder::class);
   // $this->call(Nicho_mercado_centro_costo_productSeeder::class);
    $this->call(Nicho_mercado_productSeeder::class);
    $this->call(FormapagoSeeder::class);
    $this->call(ParametrocontableSeeder::class);
    $this->call(ListaprecioSeeder::class);
    $this->call(ListapreciodetalleSeeder::class);
  }
}
