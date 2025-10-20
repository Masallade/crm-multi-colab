<?php

namespace Database\Seeders;

use App\Models\Landlord\Faq;
use App\Models\Landlord\FaqDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqData = [
            'language_id'=> 1,
            'heading'=> 'Frequently Asked Questions',
            'sub_heading'=> 'Have questions? we have answered common ones below.',
        ];

        $faq = Faq::create($faqData);

        $faqDetailData = [
            [
                'faq_id' => $faq->id,
                'question' => 'What is AvantCoreTechnologies SAAS?',
                'answer' => 'AvantCoreTechnologies SaaS is a PHP Laravel Script featuring HRM system, Payroll & Project Management.',
                'position' => 1
            ],
            [
                'faq_id' => $faq->id,
                'question' => 'Is it an addon or standalone solution?',
                'answer' => 'It is an addon solution so you have to purchase AvantCoreTechnologies before.',
                'position' => 2
            ],
            [
                'faq_id' => $faq->id,
                'question' => 'Are you selling subscriptions or selling the script?',
                'answer' => 'We are not selling subscription, but we are selling our script to various b2b and solo entrepreneurs. So, our customers can make money selling subscriptions.',
                'position' => 3
            ],
            [
                'faq_id' => $faq->id,
                'question' => 'Is your saas multi-tenant or single-tenant ?',
                'answer' => 'Our SaaS is multi-tenant, multi-database system. So, all your users will have their separate databases, sub-domains, custom domain - making it faster compared to other systems.',
                'position' => 4
            ],
            [
                'faq_id' => $faq->id,
                'question' => 'Do I have to renew ?',
                'answer' => 'Yes, you have to renew support after 6 months through codecanyon.',
                'position' => 5
            ],
            [
                'faq_id' => $faq->id,
                'question' => 'I don’t have any technical knowledge, but I want my own online subscription selling business to make money. Will it be helpful for me ?',
                'answer' => 'Definitely. What you need is to have your own website name we call it domain and hosting. We will install and set up everything for you. You just need to promote it to various businesses. Above we have a list of businesses to whom you can sell your subscription.',
                'position' => 6
            ],
            [
                'faq_id' => $faq->id,
                'question' => 'How do you provide support ?',
                'answer' => 'For our customers, we have a dedicated team of support engineers. Once you buy our product, you are enrolled in our database and can contact us at any time using the support form.',
                'position' => 7
            ],
            [
                'faq_id' => $faq->id,
                'question' => 'Who takes care of the technical issues ?',
                'answer' => 'We avantcoretech, take care of all sorts of technical issues that our clients require.',
                'position' => 8
            ],
            [
                'faq_id' => $faq->id,
                'question' => 'I have some queries before purchasing. How can I contact ?',
                'answer' => 'Use our contact form and describe your queries. Our support engineers will get back to you within 24 hours.',
                'position' => 9
            ],
            [
                'faq_id' => $faq->id,
                'question' => 'Do I need to purchase hosting ?',
                'answer' => 'No, you don\'t need to purchase hosting. You can install it to your existing hosting.',
                'position' => 10
            ]
        ];

        FaqDetail::insert($faqDetailData);
    }
}
