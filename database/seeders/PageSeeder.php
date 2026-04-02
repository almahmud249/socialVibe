<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageLanguage;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = Page::create([
            'id'         => 100,
            'title'      => 'Privacy Policy',
            'content'    => '<h2 class="privacy__content-title">
								I. Privacy Policy Personal Data <br />
								Protection
							</h2>

							<!-- Title Start -->
							<h4 class="privacy__content-subtitle">introduction</h4>
							<p>
								Lorem ipsum dolor sit amet consectetur. Tincidunt lectus viverra id vitae pellentesque massa. Amet vulputate urna id eget est nunc dolor eget donec.
								Lacus vel nunc in leo dui. Amet sed orci aliquam faucibus leo tortor semper sit nulla. Lobortis venenatis volutpat ac fames lectus est ipsum. Nisl
								turpis duis duis aliquam et aliquam massa mauris. Aliquet cras bibendum quis ac lectus id congue. Urna egestas vitae lorem diam cras. Elit mollis
								tristique sem aenean risus suspendisse elementum laoreet vestibulum.
							</p>
							<p>
								Lorem ipsum dolor sit amet consectetur. Tincidunt lectus viverra id vitae pellentesque massa. Amet vulputate urna id eget est nunc dolor eget donec.
								Lacus vel nunc in leo dui. Amet sed orci aliquam faucibus leo tortor semper sit nulla. Lobortis venenatis volutpat ac fames lectus est ipsum. Nisl
								turpis duis duis aliquam et aliquam massa mauris. Aliquet cras bibendum quis ac lectus id congue. Urna egestas vitae lorem diam cras. Elit mollis
								tristique sem aenean risus suspendisse elementum laoreet vestibulum.
							</p>

							<!-- Title Start -->
							<h4 class="privacy__content-subtitle">Definitions</h4>
							<p>
								<strong>Personal data:</strong> any information relating to an identified or identifiable natural person, that is, a person who can be identified,
								directly or indirectly, by reference to an identification number or to one or more elements specific to that person.
							</p>
							<p>
								<strong>Processing of personal data:</strong> any operation or any set of operations relating to personal data, whatever the process used, and in
								particular the collection, recording, organisation, storage, adaptation or alteration, retrieval, consultation, use, disclosure by transmission,
								dissemination or otherwise making available, alignment or combination, as well as locking, erasure, or destruction.
							</p>
							<p>
								<strong>Cookie:</strong> a cookie is a piece of information placed on the hard drive of Internet users by the server of the site they visit. It
								contains several pieces of data: the name of the server which installed it, an identifier in the form of a unique number, and possibly an expiry
								date. This information is sometimes stored on the computer in a simple text file that a server accesses to read and save pieces of information.
							</p>

							<!-- Title Start -->
							<h2 class="privacy__content-title">Data Controller - DPO</h2>
							<p>
								The data controller for the processing of the personal data referred to herein is Brevo, a simplified joint stock company with a share capital of
								387,722 Euros, registered with the Paris Trade and Companies Register under number 498 019 298 and whose registered office is located at 106
								boulevard Haussmann, 75008 Paris, France.
							</p>
							<p>Brevo has appointed a Data Protection Officer who can be contacted at the following address: <a href="#">dpo@salebot.com</a>.</p>

							<!-- Title Start -->
							<h4 class="privacy__content-subtitle">Data collected</h4>
							<p>Brevo collects data from Users in order to make the Services for which they have subscribed to the platform available to them.</p>
							<p>
								The mandatory or optional nature of the data provided (in order to complete the Users’ registration and to render the Services) is indicated at the
								time of collection by an asterisk.
							</p>
							<p>In addition, certain data is collected automatically as a result of the User’s actions on the site (see the paragraph on cookies).</p>

							<!-- Title Start -->
							<h4 class="privacy__content-subtitle">Purposes</h4>
							<p>
								The personal data collected by Brevo during the provision of the Services is necessary for the performance of the contracts concluded with the
								Users, or to allow Brevo to pursue its legitimate interests while respecting the rights of the Users. Certain data may also be processed based on
								the Users’ consent.
							</p>
							<p>The purposes for which Brevo processes data are the following:</p>
							<ul class="privacy__content-list">
								<li>commercial and accounting management of the contract;</li>
								<li>management of customer acquisition and marketing activities;</li>
								<li>detection of malicious behaviour (fraud, phishing, spam, etc.);</li>
								<li>the improvement of the Users path on the site;</li>
							</ul>

							<!-- Title Start -->
							<h2 class="privacy__content-title">Consent</h2>
							<p>
								By using or accessing our Services in any manner, you acknowledge and accept this Privacy Notice, and you consent to Brevo’s collection, use, and
								disclosure of your information as described below. If you do not agree with this Privacy Notice, do not use our Services.
							</p>',
            'type'       => 'error_page_404',
            'link'       => 'privacy-policy',
            'meta_title' => 'Privacy Policy',
            'status'     => '1',
        ]);

        PageLanguage::create([
            'page_id'       => $page->id,
            'lang'          => 'en',
            'title'         => $page->title,
            'content'       => $page->content,
            'meta_title'    => $page->meta_title,
            'meta_keywords' => $page->meta_keywords,
        ]);

        $page = Page::create([
            'id'         => 101,
            'title'      => 'Terms And Conditions',
            'content'    => '<h2 class="privacy__content-title">
								I. Privacy Policy Personal Data <br />
								Protection
							</h2>

							<!-- Title Start -->
							<h4 class="privacy__content-subtitle">introduction</h4>
							<p>
								Lorem ipsum dolor sit amet consectetur. Tincidunt lectus viverra id vitae pellentesque massa. Amet vulputate urna id eget est nunc dolor eget donec.
								Lacus vel nunc in leo dui. Amet sed orci aliquam faucibus leo tortor semper sit nulla. Lobortis venenatis volutpat ac fames lectus est ipsum. Nisl
								turpis duis duis aliquam et aliquam massa mauris. Aliquet cras bibendum quis ac lectus id congue. Urna egestas vitae lorem diam cras. Elit mollis
								tristique sem aenean risus suspendisse elementum laoreet vestibulum.
							</p>
							<p>
								Lorem ipsum dolor sit amet consectetur. Tincidunt lectus viverra id vitae pellentesque massa. Amet vulputate urna id eget est nunc dolor eget donec.
								Lacus vel nunc in leo dui. Amet sed orci aliquam faucibus leo tortor semper sit nulla. Lobortis venenatis volutpat ac fames lectus est ipsum. Nisl
								turpis duis duis aliquam et aliquam massa mauris. Aliquet cras bibendum quis ac lectus id congue. Urna egestas vitae lorem diam cras. Elit mollis
								tristique sem aenean risus suspendisse elementum laoreet vestibulum.
							</p>

							<!-- Title Start -->
							<h4 class="privacy__content-subtitle">Definitions</h4>
							<p>
								<strong>Personal data:</strong> any information relating to an identified or identifiable natural person, that is, a person who can be identified,
								directly or indirectly, by reference to an identification number or to one or more elements specific to that person.
							</p>
							<p>
								<strong>Processing of personal data:</strong> any operation or any set of operations relating to personal data, whatever the process used, and in
								particular the collection, recording, organisation, storage, adaptation or alteration, retrieval, consultation, use, disclosure by transmission,
								dissemination or otherwise making available, alignment or combination, as well as locking, erasure, or destruction.
							</p>
							<p>
								<strong>Cookie:</strong> a cookie is a piece of information placed on the hard drive of Internet users by the server of the site they visit. It
								contains several pieces of data: the name of the server which installed it, an identifier in the form of a unique number, and possibly an expiry
								date. This information is sometimes stored on the computer in a simple text file that a server accesses to read and save pieces of information.
							</p>

							<!-- Title Start -->
							<h2 class="privacy__content-title">Data Controller - DPO</h2>
							<p>
								The data controller for the processing of the personal data referred to herein is Brevo, a simplified joint stock company with a share capital of
								387,722 Euros, registered with the Paris Trade and Companies Register under number 498 019 298 and whose registered office is located at 106
								boulevard Haussmann, 75008 Paris, France.
							</p>
							<p>Brevo has appointed a Data Protection Officer who can be contacted at the following address: <a href="#">dpo@salebot.com</a>.</p>

							<!-- Title Start -->
							<h4 class="privacy__content-subtitle">Data collected</h4>
							<p>Brevo collects data from Users in order to make the Services for which they have subscribed to the platform available to them.</p>
							<p>
								The mandatory or optional nature of the data provided (in order to complete the Users’ registration and to render the Services) is indicated at the
								time of collection by an asterisk.
							</p>
							<p>In addition, certain data is collected automatically as a result of the User’s actions on the site (see the paragraph on cookies).</p>

							<!-- Title Start -->
							<h4 class="privacy__content-subtitle">Purposes</h4>
							<p>
								The personal data collected by Brevo during the provision of the Services is necessary for the performance of the contracts concluded with the
								Users, or to allow Brevo to pursue its legitimate interests while respecting the rights of the Users. Certain data may also be processed based on
								the Users’ consent.
							</p>
							<p>The purposes for which Brevo processes data are the following:</p>
							<ul class="privacy__content-list">
								<li>commercial and accounting management of the contract;</li>
								<li>management of customer acquisition and marketing activities;</li>
								<li>detection of malicious behaviour (fraud, phishing, spam, etc.);</li>
								<li>the improvement of the Users path on the site;</li>
							</ul>

							<!-- Title Start -->
							<h2 class="privacy__content-title">Consent</h2>
							<p>
								By using or accessing our Services in any manner, you acknowledge and accept this Privacy Notice, and you consent to Brevo’s collection, use, and
								disclosure of your information as described below. If you do not agree with this Privacy Notice, do not use our Services.
							</p>',
            'type'       => 'error_page_403',
            'link'       => 'terms-and-conditions',
            'meta_title' => 'Terms And Conditions',
            'status'     => '1',
        ]);

        PageLanguage::create([
            'page_id'       => $page->id,
            'lang'          => 'en',
            'title'         => $page->title,
            'content'       => $page->content,
            'meta_title'    => $page->meta_title,
            'meta_keywords' => $page->meta_keywords,
        ]);

    }
}
