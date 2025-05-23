<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Website;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Website 1
        $website1 = new Website();
        $website1->user_id = '10';
        $website1->website_url = "https://www.techcrunch.com";
        $website1->host_url = "techcrunch.com";
        $website1->da = "94";
        $website1->dr = "92";
        $website1->authority_score = "89";
        $website1->backlink_type = "dofollow";
        $website1->spam_score = "2";
        $website1->sample_post = "https://www.techcrunch.com/best-productivity-tools-for-remote-teams/";
        $website1->ahref_traffic = "8274630";
        $website1->semrush = "9567430";
        $website1->tat = "5 days";
        $website1->country = "United States";
        $website1->normal_category = "Technology";
        $website1->guest_post_price = "450.00";
        $website1->linkinsertion_price = "300.00";
        $website1->guidelines = "Word count: 1500-2000 words, No promotional content, Maximum 2 links, Original content only";
        $website1->status = "4";
        $website1->website_name = "TechCrunch";
        $website1->save();

        // Website 2
        $website2 = new Website();
        $website2->user_id = '10';
        $website2->website_url = "https://www.healthline.com";
        $website2->host_url = "healthline.com";
        $website2->da = "93";
        $website2->dr = "91";
        $website2->authority_score = "88";
        $website2->backlink_type = "dofollow";
        $website2->spam_score = "1";
        $website2->sample_post = "https://www.healthline.com/nutrition/benefits-of-meditation";
        $website2->ahref_traffic = "7845290";
        $website2->semrush = "8245780";
        $website2->tat = "7 days";
        $website2->country = "United States";
        $website2->normal_category = "Health & Wellness";
        $website2->guest_post_price = "380.00";
        $website2->linkinsertion_price = "250.00";
        $website2->guidelines = "Word count: 1200 words, Expert sources required, 2 backlinks maximum, Medical disclaimer needed";
        $website2->status = "4";
        $website2->website_name = "Healthline";
        $website2->save();

        // Website 3
        $website3 = new Website();
        $website3->user_id = '10';
        $website3->website_url = "https://www.forbes.com";
        $website3->host_url = "forbes.com";
        $website3->da = "95";
        $website3->dr = "94";
        $website3->authority_score = "92";
        $website3->backlink_type = "dofollow";
        $website3->spam_score = "1";
        $website3->sample_post = "https://www.forbes.com/sites/forbestechcouncil/digital-transformation-strategies/";
        $website3->ahref_traffic = "12457830";
        $website3->semrush = "13678540";
        $website3->tat = "10 days";
        $website3->country = "United States";
        $website3->normal_category = "Business";
        $website3->guest_post_price = "650.00";
        $website3->linkinsertion_price = "450.00";
        $website3->guidelines = "Word count: 1800-2500 words, Industry expert author required, Maximum 3 dofollow links, No promotional language";
        $website3->status = "4";
        $website3->website_name = "Forbes";
        $website3->save();

        // Website 4
        $website4 = new Website();
        $website4->user_id = '2';
        $website4->website_url = "https://www.lifehacker.com";
        $website4->host_url = "lifehacker.com";
        $website4->da = "89";
        $website4->dr = "86";
        $website4->authority_score = "84";
        $website4->backlink_type = "dofollow";
        $website4->spam_score = "3";
        $website4->sample_post = "https://www.lifehacker.com/productivity/best-time-management-techniques";
        $website4->ahref_traffic = "5632410";
        $website4->semrush = "6123450";
        $website4->tat = "6 days";
        $website4->country = "United States";
        $website4->normal_category = "Lifestyle";
        $website4->guest_post_price = "275.00";
        $website4->linkinsertion_price = "180.00";
        $website4->guidelines = "Word count: 1000-1500 words, Practical tips required, 2 links maximum, Original images encouraged";
        $website4->status = "4";
        $website4->website_name = "Lifehacker";
        $website4->save();

        // Website 5
        $website5 = new Website();
        $website5->user_id = '2';
        $website5->website_url = "https://www.mashable.com";
        $website5->host_url = "mashable.com";
        $website5->da = "92";
        $website5->dr = "89";
        $website5->authority_score = "86";
        $website5->backlink_type = "dofollow";
        $website5->spam_score = "2";
        $website5->sample_post = "https://www.mashable.com/article/future-of-artificial-intelligence";
        $website5->ahref_traffic = "7123450";
        $website5->semrush = "7564380";
        $website5->tat = "8 days";
        $website5->country = "United States";
        $website5->normal_category = "Technology";
        $website5->guest_post_price = "320.00";
        $website5->linkinsertion_price = "220.00";
        $website5->guidelines = "Word count: 1200-1800 words, Engaging content, 3 links maximum, Original research preferred";
        $website5->status = "4";
        $website5->website_name = "Mashable";
        $website5->save();

        // Website 6
        $website6 = new Website();
        $website6->user_id = '2';
        $website6->website_url = "https://www.entrepreneur.com";
        $website6->host_url = "entrepreneur.com";
        $website6->da = "92";
        $website6->dr = "90";
        $website6->authority_score = "87";
        $website6->backlink_type = "dofollow";
        $website6->spam_score = "2";
        $website6->sample_post = "https://www.entrepreneur.com/growing-a-business/startup-funding-strategies";
        $website6->ahref_traffic = "6783250";
        $website6->semrush = "7245130";
        $website6->tat = "12 days";
        $website6->country = "United States";
        $website6->normal_category = "Business";
        $website6->guest_post_price = "550.00";
        $website6->linkinsertion_price = "380.00";
        $website6->guidelines = "Word count: 1500-2000 words, Business expert author required, Maximum 2 dofollow links, Case studies encouraged";
        $website6->status = "4";
        $website6->website_name = "Entrepreneur";
        $website6->save();

        // Website 7
        $website7 = new Website();
        $website7->user_id = '3';
        $website7->website_url = "https://www.webmd.com";
        $website7->host_url = "webmd.com";
        $website7->da = "94";
        $website7->dr = "92";
        $website7->authority_score = "90";
        $website7->backlink_type = "dofollow";
        $website7->spam_score = "1";
        $website7->sample_post = "https://www.webmd.com/fitness-exercise/benefits-of-regular-exercise";
        $website7->ahref_traffic = "9876540";
        $website7->semrush = "10245830";
        $website7->tat = "9 days";
        $website7->country = "United States";
        $website7->normal_category = "Health & Wellness";
        $website7->guest_post_price = "420.00";
        $website7->linkinsertion_price = "280.00";
        $website7->guidelines = "Word count: 1200-1800 words, Medical sources required, 2 backlinks maximum, Medical disclaimer needed, No promotional content";
        $website7->status = "4";
        $website7->website_name = "WebMD";
        $website7->save();

        // Website 8
        $website8 = new Website();
        $website8->user_id = '3';
        $website8->website_url = "https://www.theverge.com";
        $website8->host_url = "theverge.com";
        $website8->da = "91";
        $website8->dr = "88";
        $website8->authority_score = "85";
        $website8->backlink_type = "dofollow";
        $website8->spam_score = "2";
        $website8->sample_post = "https://www.theverge.com/tech-reviews/latest-smartphone-technology";
        $website8->ahref_traffic = "5987420";
        $website8->semrush = "6423780";
        $website8->tat = "7 days";
        $website8->country = "United States";
        $website8->normal_category = "Technology";
        $website8->guest_post_price = "350.00";
        $website8->linkinsertion_price = "230.00";
        $website8->guidelines = "Word count: 1000-1500 words, Tech expertise required, Maximum 2 dofollow links, Original insights mandatory";
        $website8->status = "4";
        $website8->website_name = "The Verge";
        $website8->save();

        // Website 9
        $website9 = new Website();
        $website9->user_id = '3';
        $website9->website_url = "https://www.investopedia.com";
        $website9->host_url = "investopedia.com";
        $website9->da = "93";
        $website9->dr = "91";
        $website9->authority_score = "88";
        $website9->backlink_type = "dofollow";
        $website9->spam_score = "1";
        $website9->sample_post = "https://www.investopedia.com/retirement-planning-guide-4689695";
        $website9->ahref_traffic = "8457230";
        $website9->semrush = "9123570";
        $website9->tat = "8 days";
        $website9->country = "United States";
        $website9->normal_category = "Finance";
        $website9->guest_post_price = "480.00";
        $website9->linkinsertion_price = "320.00";
        $website9->guidelines = "Word count: 1800-2500 words, Financial expertise required, Maximum 2 links, Financial disclaimer needed, No promotional language";
        $website9->status = "4";
        $website9->website_name = "Investopedia";
        $website9->save();

        // Website 10
        $website10 = new Website();
        $website10->user_id = '4';
        $website10->website_url = "https://www.buzzfeed.com";
        $website10->host_url = "buzzfeed.com";
        $website10->da = "90";
        $website10->dr = "87";
        $website10->authority_score = "83";
        $website10->backlink_type = "dofollow";
        $website10->spam_score = "4";
        $website10->sample_post = "https://www.buzzfeed.com/entertainment/best-streaming-shows-2024";
        $website10->ahref_traffic = "11234570";
        $website10->semrush = "12876540";
        $website10->tat = "5 days";
        $website10->country = "United States";
        $website10->normal_category = "Entertainment";
        $website10->guest_post_price = "290.00";
        $website10->linkinsertion_price = "180.00";
        $website10->guidelines = "Word count: 800-1200 words, Engaging tone, 3 links maximum, Listicle format preferred, Original images required";
        $website10->status = "4";
        $website10->website_name = "BuzzFeed";
        $website10->save();

        // Website 11
        $website11 = new Website();
        $website11->user_id = '4';
        $website11->website_url = "https://www.cnet.com";
        $website11->host_url = "cnet.com";
        $website11->da = "93";
        $website11->dr = "90";
        $website11->authority_score = "86";
        $website11->backlink_type = "dofollow";
        $website11->spam_score = "2";
        $website11->sample_post = "https://www.cnet.com/tech/computing/best-laptops-for-professionals/";
        $website11->ahref_traffic = "7658230";
        $website11->semrush = "8214360";
        $website11->tat = "7 days";
        $website11->country = "United States";
        $website11->normal_category = "Technology";
        $website11->guest_post_price = "370.00";
        $website11->linkinsertion_price = "240.00";
        $website11->guidelines = "Word count: 1200-1800 words, Tech expertise required, 2 dofollow links maximum, Product comparisons encouraged";
        $website11->status = "4";
        $website11->website_name = "CNET";
        $website11->save();

        // Website 12
        $website12 = new Website();
        $website12->user_id = '4';
        $website12->website_url = "https://www.huffpost.com";
        $website12->host_url = "huffpost.com";
        $website12->da = "92";
        $website12->dr = "90";
        $website12->authority_score = "87";
        $website12->backlink_type = "dofollow";
        $website12->spam_score = "2";
        $website12->sample_post = "https://www.huffpost.com/entry/mental-health-awareness-strategies";
        $website12->ahref_traffic = "9876540";
        $website12->semrush = "10354820";
        $website12->tat = "6 days";
        $website12->country = "United States";
        $website12->normal_category = "News";
        $website12->guest_post_price = "310.00";
        $website12->linkinsertion_price = "200.00";
        $website12->guidelines = "Word count: 1000-1500 words, Factual content, Maximum 2 links, Expert sources required, No promotional language";
        $website12->status = "4";
        $website12->website_name = "HuffPost";
        $website12->save();

        // Website 13
        $website13 = new Website();
        $website13->user_id = '5';
        $website13->website_url = "https://www.thedailybeast.com";
        $website13->host_url = "thedailybeast.com";
        $website13->da = "90";
        $website13->dr = "87";
        $website13->authority_score = "84";
        $website13->backlink_type = "dofollow";
        $website13->spam_score = "3";
        $website13->sample_post = "https://www.thedailybeast.com/politics/election-analysis-2024";
        $website13->ahref_traffic = "4567820";
        $website13->semrush = "5123470";
        $website13->tat = "8 days";
        $website13->country = "United States";
        $website13->normal_category = "Politics";
        $website13->guest_post_price = "280.00";
        $website13->linkinsertion_price = "190.00";
        $website13->guidelines = "Word count: 1200-1800 words, Factual reporting, 2 links maximum, Expert quotes required, No promotional content";
        $website13->status = "4";
        $website13->website_name = "The Daily Beast";
        $website13->save();

        // Website 14
        $website14 = new Website();
        $website14->user_id = '5';
        $website14->website_url = "https://www.medium.com";
        $website14->host_url = "medium.com";
        $website14->da = "95";
        $website14->dr = "93";
        $website14->authority_score = "91";
        $website14->backlink_type = "dofollow";
        $website14->spam_score = "1";
        $website14->sample_post = "https://www.medium.com/productivity-hacks-for-creative-professionals";
        $website14->ahref_traffic = "14532680";
        $website14->semrush = "15687430";
        $website14->tat = "4 days";
        $website14->country = "United States";
        $website14->normal_category = "Various";
        $website14->guest_post_price = "220.00";
        $website14->linkinsertion_price = "150.00";
        $website14->guidelines = "Word count: 1000-2500 words, Original content only, Maximum 3 links, Personal insights encouraged";
        $website14->status = "4";
        $website14->website_name = "Medium";
        $website14->save();

        // Website 15
        $website15 = new Website();
        $website15->user_id = '5';
        $website15->website_url = "https://www.foodandwine.com";
        $website15->host_url = "foodandwine.com";
        $website15->da = "91";
        $website15->dr = "88";
        $website15->authority_score = "85";
        $website15->backlink_type = "dofollow";
        $website15->spam_score = "2";
        $website15->sample_post = "https://www.foodandwine.com/cooking-techniques/perfect-pasta-recipes";
        $website15->ahref_traffic = "3876540";
        $website15->semrush = "4235780";
        $website15->tat = "7 days";
        $website15->country = "United States";
        $website15->normal_category = "Food & Dining";
        $website15->guest_post_price = "290.00";
        $website15->linkinsertion_price = "180.00";
        $website15->guidelines = "Word count: 1000-1500 words, Original recipes required, Maximum 2 dofollow links, High-quality food images needed";
        $website15->status = "4";
        $website15->website_name = "Food & Wine";
        $website15->save();

        // Website 16
        $website16 = new Website();
        $website16->user_id = '6';
        $website16->website_url = "https://www.wired.com";
        $website16->host_url = "wired.com";
        $website16->da = "94";
        $website16->dr = "92";
        $website16->authority_score = "89";
        $website16->backlink_type = "dofollow";
        $website16->spam_score = "1";
        $website16->sample_post = "https://www.wired.com/story/future-of-quantum-computing";
        $website16->ahref_traffic = "6234780";
        $website16->semrush = "6897450";
        $website16->tat = "9 days";
        $website16->country = "United States";
        $website16->normal_category = "Technology";
        $website16->guest_post_price = "490.00";
        $website16->linkinsertion_price = "320.00";
        $website16->guidelines = "Word count: 1500-2500 words, Tech expertise required, Maximum 2 dofollow links, Original research preferred";
        $website16->status = "4";
        $website16->website_name = "Wired";
        $website16->save();

        // Website 17
        $website17 = new Website();
        $website17->user_id = '6';
        $website17->website_url = "https://www.theguardian.com";
        $website17->host_url = "theguardian.com";
        $website17->da = "95";
        $website17->dr = "94";
        $website17->authority_score = "92";
        $website17->backlink_type = "dofollow";
        $website17->spam_score = "1";
        $website17->sample_post = "https://www.theguardian.com/environment/climate-crisis";
        $website17->ahref_traffic = "18734560";
        $website17->semrush = "19876540";
        $website17->tat = "10 days";
        $website17->country = "United Kingdom";
        $website17->normal_category = "News";
        $website17->guest_post_price = "580.00";
        $website17->linkinsertion_price = "390.00";
        $website17->guidelines = "Word count: 1800-2500 words, Factual reporting, Expert sources required, Maximum 2 links, No promotional language";
        $website17->status = "4";
        $website17->website_name = "The Guardian";
        $website17->save();

        // Website 18
        $website18 = new Website();
        $website18->user_id = '6';
        $website18->website_url = "https://www.travelchannel.com";
        $website18->host_url = "travelchannel.com";
        $website18->da = "88";
        $website18->dr = "85";
        $website18->authority_score = "82";
        $website18->backlink_type = "dofollow";
        $website18->spam_score = "3";
        $website18->sample_post = "https://www.travelchannel.com/destinations/hidden-gems-southeast-asia";
        $website18->ahref_traffic = "2765430";
        $website18->semrush = "3124570";
        $website18->tat = "6 days";
        $website18->country = "United States";
        $website18->normal_category = "Travel";
        $website18->guest_post_price = "250.00";
        $website18->linkinsertion_price = "170.00";
        $website18->guidelines = "Word count: 1000-1500 words, First-hand travel experience required, Maximum 3 links, High-quality travel images needed";
        $website18->status = "4";
        $website18->website_name = "Travel Channel";
        $website18->save();

        // Website 19
        $website19 = new Website();
        $website19->user_id = '7';
        $website19->website_url = "https://www.bbcgoodfood.com";
        $website19->host_url = "bbcgoodfood.com";
        $website19->da = "90";
        $website19->dr = "87";
        $website19->authority_score = "84";
        $website19->backlink_type = "dofollow";
        $website19->spam_score = "2";
        $website19->sample_post = "https://www.bbcgoodfood.com/recipes/collection/vegetarian-dinner-recipes";
        $website19->ahref_traffic = "5432170";
        $website19->semrush = "5987650";
        $website19->tat = "5 days";
        $website19->country = "United Kingdom";
        $website19->normal_category = "Food & Dining";
        $website19->guest_post_price = "240.00";
        $website19->linkinsertion_price = "160.00";
        $website19->guidelines = "Word count: 800-1200 words, Original recipes required, Maximum 2 dofollow links, Step-by-step instructions needed";
        $website19->status = "4";
        $website19->website_name = "BBC Good Food";
        $website19->save();

        // Website 20
        $website20 = new Website();
        $website20->user_id = '7';
        $website20->website_url = "https://www.gizmodo.com";
        $website20->host_url = "gizmodo.com";
        $website20->da = "91";
        $website20->dr = "88";
        $website20->authority_score = "85";
        $website20->backlink_type = "dofollow";
        $website20->spam_score = "2";
        $website20->sample_post = "https://www.gizmodo.com/tech-reviews/latest-gadget-innovations";
        $website20->ahref_traffic = "4876530";
        $website20->semrush = "5231470";
        $website20->tat = "6 days";
        $website20->country = "United States";
        $website20->normal_category = "Technology";
        $website20->guest_post_price = "310.00";
        $website20->linkinsertion_price = "210.00";
        $website20->guidelines = "Word count: 1000-1500 words, Tech expertise required, Maximum 2 dofollow links, Original insights mandatory";
        $website20->status = "4";
        $website20->website_name = "Gizmodo";
        $website20->save();

        // Website 21
        $website21 = new Website();
        $website21->user_id = '7';
        $website21->website_url = "https://www.psychologytoday.com";
        $website21->host_url = "psychologytoday.com";
        $website21->da = "92";
        $website21->dr = "90";
        $website21->authority_score = "87";
        $website21->backlink_type = "dofollow";
        $website21->spam_score = "1";
        $website21->sample_post = "https://www.psychologytoday.com/us/blog/mindfulness-wellbeing";
        $website21->ahref_traffic = "7865430";
        $website21->semrush = "8342760";
        $website21->tat = "8 days";
        $website21->country = "United States";
        $website21->normal_category = "Psychology & Mental Health";
        $website21->guest_post_price = "390.00";
        $website21->linkinsertion_price = "260.00";
        $website21->guidelines = "Word count: 1200-1800 words, Psychology credentials required, Maximum 2 links, Scientific sources needed, No promotional language";
        $website21->status = "4";
        $website21->website_name = "Psychology Today";
        $website21->save();

        // Website 22
        $website22 = new Website();
        $website22->user_id = '8';
        $website22->website_url = "https://www.nationalgeographic.com";
        $website22->host_url = "nationalgeographic.com";
        $website22->da = "95";
        $website22->dr = "93";
        $website22->authority_score = "91";
        $website22->backlink_type = "dofollow";
        $website22->spam_score = "1";
        $website22->sample_post = "https://www.nationalgeographic.com/environment/article/ocean-conservation-efforts";
        $website22->ahref_traffic = "9876540";
        $website22->semrush = "10342780";
        $website22->tat = "12 days";
        $website22->country = "United States";
        $website22->normal_category = "Science & Nature";
        $website22->guest_post_price = "620.00";
        $website22->linkinsertion_price = "420.00";
        $website22->guidelines = "Word count: 2000-3000 words, Expert sources required, Maximum 2 dofollow links, Scientific accuracy mandatory, Original photography preferred";
        $website22->status = "4";
        $website22->website_name = "National Geographic";
        $website22->save();

        // Website 23
        $website23 = new Website();
        $website23->user_id = '8';
        $website23->website_url = "https://www.pcmag.com";
        $website23->host_url = "pcmag.com";
        $website23->da = "92";
        $website23->dr = "89";
        $website23->authority_score = "86";
        $website23->backlink_type = "dofollow";
        $website23->spam_score = "2";
        $website23->sample_post = "https://www.pcmag.com/reviews/best-laptops-for-video-editing";
        $website23->ahref_traffic = "5234680";
        $website23->semrush = "5789430";
        $website23->tat = "7 days";
        $website23->country = "United States";
        $website23->normal_category = "Technology";
        $website23->guest_post_price = "340.00";
        $website23->linkinsertion_price = "230.00";
        $website23->guidelines = "Word count: 1200-1800 words, Tech expertise required, Maximum 2 dofollow links, Product comparisons encouraged";
        $website23->status = "4";
        $website23->website_name = "PCMag";
        $website23->save();

        // Website 24
        $website24 = new Website();
        $website24->user_id = '8';
        $website24->website_url = "https://www.prevention.com";
        $website24->host_url = "prevention.com";
        $website24->da = "89";
        $website24->dr = "86";
        $website24->authority_score = "83";
        $website24->backlink_type = "dofollow";
        $website24->spam_score = "2";
        $website24->sample_post = "https://www.prevention.com/fitness/workout-routines/home-exercise-plan";
        $website24->ahref_traffic = "4235670";
        $website24->semrush = "4687520";
        $website24->tat = "6 days";
        $website24->country = "United States";
        $website24->normal_category = "Health & Wellness";
        $website24->guest_post_price = "270.00";
        $website24->linkinsertion_price = "180.00";
        $website24->guidelines = "Word count: 1000-1500 words, Health expertise required, Maximum 2 links, Medical sources needed, No promotional language";
        $website24->status = "4";
        $website24->website_name = "Prevention";
        $website24->save();

        // Website 25
        $website25 = new Website();
        $website25->user_id = '9';
        $website25->website_url = "https://www.fotolog.com";
        $website25->host_url = "fotolog.com";
        $website25->da = "88";
        $website25->dr = "84";
        $website25->authority_score = "81";
        $website25->backlink_type = "dofollow";
        $website25->spam_score = "5";
        $website25->sample_post = "https://www.fotolog.com/advantages-of-banking-software-applications/";
        $website25->ahref_traffic = "1635165";
        $website25->semrush = "1876420";
        $website25->tat = "4 days";
        $website25->country = "United States";
        $website25->normal_category = "Photography & Lifestyle";
        $website25->guest_post_price = "95.00";
        $website25->linkinsertion_price = "65.00";
        $website25->guidelines = "Word count: 1000 words, Anchor has to be domain name, Only domain link, 1 keyword must not repeat more than 15 times";
        $website25->status = "4";
        $website25->website_name = "Foto Log";
        $website25->save(); 
    }
}
