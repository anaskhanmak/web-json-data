<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Inertia\Inertia;

class FrontendController extends Controller
{
    // ##################### Website Pages ######################
    public function home()
    {
        return view(
            'frontend.pages.home',
            [
                'title' => 'Book Editing | Book Formatting| Book Publishing| Kindle Book Publishers Hub',
                'description' => 'Get professional book editing, formatting, and publishing services in the U.S. Improve your manuscript, achieve publishing success, and grow your readership with us.
',
            ]
        );
    }
    
    public function bookpublishing()
    {
        return view(
            'frontend.pages.book-publishing',
            [
                'title' => 'Professional Book Publishing Service For Authors in U.S. | Kindle Book Publishers Hub
',
                'description' => 'Publish your book confidently with professional book publishing services in the U.S. Kindle Book Publishers Hub provides expert guidance and a proven path to author success.
',
            ]
        );
    }
    public function editingformatting()
    {
        return view(
            'frontend.pages.editing-formatting',
            [
                'title' => 'Get Expert Book Editing & Formatting Services in U.S. | Kindle Book Publishers Hub
',
                'description' => 'Refine and publish your manuscript with expert book editing and formatting services in the U.S. Reach more readers, build your author brand, and launch your book.
',
            ]
        );
    }
public function illustrationdesign()
    {
        return view(
            'frontend.pages.illustration-design',
            [
                'title' => 'Professional Book Illustration Design Service in U.S. | Kindle Book Publishers Hub
',
                'description' => 'Enhance your story with expert book illustration services in the U.S. Kindle Book Publishers Hub delivers custom artwork tailored to your genre, audience, and publishing goals.
',
            ]
        );
    }
public function coverdesign()
    {
        return view(
            'frontend.pages.cover-design',
            [
                'title' => 'Custom Book Cover Design Service in U.S. | Kindle Book Publishers Hub
',
                'description' => 'Attract more readers with a stunning custom book cover design in the U.S. Kindle Book Publishers Hub creates eye-catching covers that can enhance your readership.
',
            ]
        );
    }
public function authorwebsite()
    {
        return view(
            'frontend.pages.author-website',
            [
                'title' => 'Custom Author Website Design & Development Service in U.S. | Kindle Book Publishers Hub
',
                'description' => 'Boost your online visibility with a custom author website in the U.S. Kindle Book Publishers Hub can help you build a professional and SEO-optimized website to grow your name.
',
            ]
        );
    }
public function audiobookproduction()
    {
        return view(
            'frontend.pages.audiobook-production',
            [
                'title' => 'Professional Audiobook Production Service in U.S. | Kindle Book Publishers Hub
',
                'description' => 'Get premium audiobook production services in the U.S. by Kindle Book Publishers Hub. We produce high-quality, engaging audio for authors, publishers, and storytellers.
',
            ]
        );
    }
    public function about()
    {
        return view(
            'frontend.pages.about-us',
            [
                'title' => 'Get To Know About Us, Our Team, & Our Work | Kindle Book Publishers Hub
',
                'description' => 'Discover all about Kindle Book Publishers Hub, a leading U.S. book publishing company helping authors achieve proven success in their professional journey.
',
            ]
        );
    }

    public function contact()
    {
        return view(
            'frontend.pages.contact-us',
            [
                'title' => 'Contact Us For Instant Support & Assistance | Kindle Book Publishers Hub
',
                'description' => 'Need fast publishing help? Contact Kindle Book Publishers Hub for expert guidance, book publishing support, and professional author services in the U.S.
',
            ]
        );
    }


    // LP
    public function publishing()
    {
        return view(
            'frontend.pages.lp.publishing',
            [
                'title' => 'Professional Book Publishing Service For Authors in U.S. | Kindle Book Publishers Hub
',
                'description' => 'Publish your book confidently with professional book publishing services in the U.S. Kindle Book Publishers Hub provides expert guidance and a proven path to author success.
',
            ]
        );
    }
      public function termsAndConditions()
    {
        return view(
            'frontend.pages.terms-and-conditions',
            [
                'title' => 'Terms and Conditions | Kindle Book Publishers Hub',
                'description' => '',
            ]
        );
    }
          public function lpTermsAndConditions()
    {
        return view(
            'frontend.pages.lp-terms-and-conditions',
            [
                'title' => 'Terms and Conditions | Kindle Book Publishers Hub',
                'description' => '',
            ]
        );
    }
       public function privacy()
    {
        return view(
            'frontend.pages.privacy-policy',
            [
                'title' => 'Privacy Policy | Kindle Book Publishers Hub',
                'description' => '',
            ]
        );
    }
           public function lpPrivacy()
    {
        return view(
            'frontend.pages.lp-privacy-policy',
            [
                'title' => 'Privacy Policy | Kindle Book Publishers Hub',
                'description' => '',
            ]
        );
    }
    public function thankyou()
    {
           return view('frontend.pages.thankyou',
            [
                'title' => 'Thank You | Kindle Book Publishers Hub',
                'description' => '',
            ]
        );
    }
    public function reactInvoicePayment()
    {
           return view('frontend.pages.invoice.Invoice',
            [
                'title' => 'Invoice | Kindle Book Publishers Hub',
                'description' => '',
            ]
        );
    }


    public function seq_step1()
    {
        return view(
            'frontend.pages.sequence.step1',
            [
                'title' => 'Sequnce Step 1 - Register a Brand',
                'description' => '',
            ]
        );
    }
}
