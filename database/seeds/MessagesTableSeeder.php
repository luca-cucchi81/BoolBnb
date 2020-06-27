<?php

use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

use App\Message;
use App\Apartment;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $messages = [
            'Buongiorno, quando posso ricevere le chiavi dell\'appartamento?',
            'Ciao, ho visto che è presente il servizio Portineria. Saprebbe gentilmente dirmi a che ore chiude la sera?',
            'Ciao, in questo appartamento è possibile portare cani di piccola taglia?',
            'Buongiorno, chiedevo se era possibile ricevere un preventivo per email per una settimana ad Agosto',
            'Salve, l\'appartamento è provvisto di aria condizionata? Grazie mille per la risposta',
            'Salve, sarei interessato a prenotare questo appartamento. Dalla Stazione Centrale quale autobus devo prendere per raggiugnerlo?',
            'Buongiorno, chiedevo se era possibile saldare il conto per la prenotazione con carta di credito American Express',
            'Ciao, è disponibile un servizio Lavanderia in caso di prenotazione per un mese intero?',
            'Buongiorno, chiedevo se era presente un servizio di frigo bar all\'interno del locale',
            'Ciao, come posso raggiungere l\'appartamento dall\'aeroporto utilizzando solo mezzi pubblici?'
        ];

        for ($i=0; $i < 200; $i++) {
            $message = new Message;
            $apartment = Apartment::inRandomOrder()->first();
            $message->apartment_id = $apartment->id;
            $message->sender = $faker->email();
            $message->body = $messages[rand(0, 9)];
            $message->read = 0;
            $message->save();
        }
    }
}
