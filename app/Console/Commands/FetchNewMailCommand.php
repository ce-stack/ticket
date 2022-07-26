<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;

class FetchNewMailCommand extends Command
{
    protected $signature = 'fetch:mail';

    protected $description = 'Fetch new mails from support mail';

    public function handle()
    {
        $client = Client::account("default");

        $client = $client->connect();



        $folders = $client->getFolders();
        foreach ($folders as $folder) {
            $folder->messages()->fetchOrderDesc()->all()->chunked(function($messages, $chunk){
                $messages->each(function($message){
                    if (!$message->getFlags()->has('seen')) {
                        $matches = null;
                        if (preg_match("/\s*\w*\s*##.*?##/",$message->getHTMLBody(),$matches) > 0) {
                            $ticket_id = preg_replace('/[^0-9]/', '', $matches);
                            $ticket_id = $ticket_id[0];
                            if ($ticket_id != "") {
                                $reply = new \App\Models\Reply();
                                $reply->content = $message->getHTMLBody();
                                $reply->ticket_id = $ticket_id;
                                $reply->save();
                            }


                        } else {
                            $ticket = new Ticket();
                            $ticket->subject = $message->get('subject')->toString();
                            $ticket->content = $message->getHtmlBody();
                            $ticket->email =  $message->get('from')->first()->mail;
                            $ticket->save();
                        }

                        $message->setFlag('Seen');

                    }



                });
            },50, 1)  ;
        }
    }
}
