<?php

namespace Workdo\Documents\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmailTemplate;
use App\Models\EmailTemplateLang;

class EmailTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $emailTemplate = [
            'Contract',
        ];

        $defaultTemplate = [
            'Contract' => [
                'subject' => 'Contract',
                'variables' => '{
                    "Contract Subject": "document_subject",
                    "Contract Client": "document_client",
                    "Contract Strat Date Stage": "document_start_date",
                    "Contract End Date": "document_end_date",
                    "App Url": "app_url",
                    "App Name": "app_name",
                    "Company Name ":"company_name",
                    "Email" : "email"
                }',
                'lang' => [
                    'ar' => '<p><span style="font-family: sans-serif;"><strong>مرحبا </strong>{ document_client } </span></p>
                    <p><span style="font-family: sans-serif;"><strong><strong>العقد :</strong> </strong>{ document_subject } </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>تاريخ البدء</strong>: { document_start_date } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>تاريخ الانتهاء</strong>: { document_end_date } </span></p>
                    <p><span style="font-family: sans-serif;">اتطلع للسمع منك. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Regards Regards ، </span></strong></p>
                    <p><span style="font-family: sans-serif;">{ company_name }</span></p>',
                    'da' => '<p><span style="font-family: sans-serif;"><strong>Hej </strong>{ document_client } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Aftaleemne:</strong> { document_subject } </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>tart-dato</strong>: { document_start_date } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Slutdato</strong>: { document_end_date } </span></p>
                    <p><span style="font-family: sans-serif;">Ser frem til at høre fra dig. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Kærlig hilsen </span></strong></p>
                    <p><span style="font-family: sans-serif;">{ company_name }</span></p>',
                    'de' => '<p><span style="font-family: sans-serif;"><strong><strong> </strong></strong>{document_client} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Vertragssubjekt:</strong> {document_subject} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>tart-Datum</strong>: {document_start_date} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>: </strong>{document_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">Freuen Sie sich auf die von Ihnen zu h&ouml;renden Informationen. </span></p>
                    <p><strong><span style="font-family: sans-serif;"><span style="font-family: sans-serif;">-Regards, </span></span></strong></p>
                    <p><span style="font-family: sans-serif;">{company_name}</span></p>',
                    'en' => '<p><span style="font-family: sans-serif;"><strong>Hi </strong>{document_client} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Contract Subject:</strong> {document_subject} </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>tart Date</strong>: {document_start_date} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>End Date</strong>: {document_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">Looking forward to hear from you. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Kind Regards, </span></strong></p>
                    <p><span style="font-family: sans-serif;">{company_name}</span></p>',
                    'es' => '<p><span style="font-family: sans-serif;"><strong><strong>Hi </strong></strong>{document_client} </span></p>
                    <p><span style="font-family: sans-serif;"><strong><strong>de contrato:</strong> </strong>{document_subject} </span></p>
                    <p><strong><span style="font-family: sans-serif;"><span style="font-family: sans-serif;">S</span></span></strong><span style="font-family: sans-serif;"><strong>tart Date</strong>: {document_start_date} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Fecha de finalizaci&oacute;n</strong>: {document_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">Con ganas de escuchar de usted. </span></p>
                    <p><strong><span style="font-family: sans-serif;"><span style="font-family: sans-serif;">Regards de tipo, </span></span></strong></p>
                    <p><span style="font-family: sans-serif;">{document_name}</span></p>',
                    'fr' => '<p><span style="font-family: sans-serif;"><strong><strong> </strong></strong>{ document_client } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Objet du contrat:</strong> { document_subject } </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>Date de d&eacute;but</strong>: { document_start_date } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Date de fin</strong>: { document_end_date } </span></p>
                    <p><span style="font-family: sans-serif;">Vous avez h&acirc;te de vous entendre. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Kind Regards </span> </strong></p>
                    <p><span style="font-family: sans-serif;">{ company_name }</span></p>',
                    'it' => '<p><span style="font-family: sans-serif;"><strong>Ciao </strong>{document_client} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Oggetto Contratto:</strong> {document_subject} </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>Data tarte</strong>: {document_start_date} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Data di fine</strong>: {document_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">Non vedo lora di sentire da te. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Kind indipendentemente, </span></strong></p>
                    <p><span style="font-family: sans-serif;">{company_name}</span></p>',
                    'ja' => '<p><span style="font-family: sans-serif;"><span style="font-family: sans-serif;"><strong>ハイ </strong>{document_client} </span></span></p>
                    <p><span style="font-family: sans-serif;"><strong>契約件名:</strong> {契約対象} </span></p>
                    <p><strong><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>tart Date</strong>: </span></strong><span style="font-family: sans-serif;">{document_start_date}</span><span style="font-family: sans-serif;"> </span></p>
                    <p><span style="font-family: sans-serif;"><strong>終了日</strong>: {document_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">お客様から連絡をお待ちしています。 </span></p>
                    <p><strong><span style="font-family: sans-serif;"><span style="font-family: sans-serif;">クインド・レード </span></span></strong></p>
                    <p><span style="font-family: sans-serif;">{company_name}</span></p>',
                    'nl' => '<p><span style="font-family: sans-serif;"><strong>Hi </strong>{ document_client } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Contractonderwerp:</strong> { document_subject } </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>tart Date</strong>: { document_start_date } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Einddatum</strong>: { document_end_date } </span></p>
                    <p><span style="font-family: sans-serif;">Ik kijk ernaar uit om van u te horen. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Soort Regards, </span></strong></p>
                    <p><span style="font-family: sans-serif;">{ company_name }</span></p>',
                    'pl' => '<p><span style="font-family: sans-serif;"><strong>Hi </strong>{document_client}</span></p>
                    <p><span style="font-family: sans-serif;"><strong>Temat umowy:</strong> {document_subject} </span></p>
                    <p><strong><span style="font-family: sans-serif;"><span style="font-family: sans-serif;">S</span></span></strong><span style="font-family: sans-serif;"><strong>data tartu</strong>: {document_start_date} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Data zakończenia</strong>: {document_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">Nie można się doczekać, aby usłyszeć od użytkownika. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Regaty typu, </span></strong></p>
                    <p><span style="font-family: sans-serif;">{company_name}</span></p>',
                    'ru' => '<p><span style="font-family: sans-serif;"><strong>Привет </strong>{ document_client } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Тема договора:</strong> { document_subject } </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>дата запуска</strong>: { document_start_date } </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Дата окончания</strong>: { document_end_date } </span></p>
                    <p><span style="font-family: sans-serif;">С нетерпением ожидаю услышать от вас. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Карты вида, </span></strong></p>
                    <p><span style="font-family: sans-serif;">{ company_name }</span></p>',
                    'pt' => '<p><span style="font-family: sans-serif;"><strong>Oi </strong>{document_client} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Assunto do Contrato:</strong> {document_subject} </span></p>
                    <p><strong><span style="font-family: sans-serif;">S</span></strong><span style="font-family: sans-serif;"><strong>tart Date</strong>: {document_start_date} </span></p>
                    <p><span style="font-family: sans-serif;"><strong>Data de término</strong>: {document_end_date} </span></p>
                    <p><span style="font-family: sans-serif;">Olhando para a frente para ouvir de você. </span></p>
                    <p><strong><span style="font-family: sans-serif;">Kind Considerar, </span></strong></p>
                    <p><span style="font-family: sans-serif;">{company_name}</span></p>',
                ],
            ],
        ];

        foreach ($emailTemplate as $eTemp) {
            $table = EmailTemplate::where('name', $eTemp)->where('module_name', 'Contract')->exists();
            if (!$table) {
                $emailtemplate =  EmailTemplate::create(
                    [
                        'name' => $eTemp,
                        'from' => 'Contract',
                        'module_name' => 'Contract',
                        'created_by' => 1,
                        'workspace_id' => 0
                    ]
                );
                foreach ($defaultTemplate[$eTemp]['lang'] as $lang => $content) {
                    EmailTemplateLang::create(
                        [
                            'parent_id' => $emailtemplate->id,
                            'lang' => $lang,
                            'subject' => $defaultTemplate[$eTemp]['subject'],
                            'variables' => $defaultTemplate[$eTemp]['variables'],
                            'content' => $content,
                        ]
                    );
                }
            }
        }
    }
}
