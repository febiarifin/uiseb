 <!-- Contact Section Begin -->
 <section class="contact-section spad bg-wayang">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-title">
                    <h2>CONTACT US</h2>
                </div>
                <div class="cs-text">
                    <div class="ct-address">
                        <span>Address:</span>
                        <p>Faculty of Economic and Busines UNSIQ <br /> Jl. KH. Hasyim Asy'ari Km. 03, Kaliber,
                            Kec. Mojotengah, Kab. Wonosobo,
                            Jawa Tengah - 56351</p>
                    </div>
                    <ul>
                        <li>
                            <span>Telephone:</span>
                            (0286) 3396204
                        </li>
                        <li>
                            <span>Email:</span>
                            uiseb-feb@unsiq.ac.id
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-title">
                    <h2>CONTACT PERSON</h2>
                </div>
                <div class="cs-text">
                    @foreach ($page->contacts as $contact)
                        <a href="https://api.whatsapp.com/send?phone={{ $contact->phone_number }}" class="text-primary"
                            target="_blank"> {{ $contact->phone_number }}
                            ({{ $contact->name }})
                        </a>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->
<div class="text-center p-2" style="background-color: #f3f3f3;">
    <img src="{{ asset('assets/images/Web_of_Science-2.png') }}" height="80">
    <img src="{{ asset('assets/images/Scopus_logo.png') }}" height="80">
    <img src="{{ asset('assets/images/sinta_logo.png') }}" height="80">
    <img src="{{ asset('assets/images/all_conference.png') }}" height="70">
</div>
@if (count($page->sponsors) != 0)
    <div class="text-center p-2" style="background-color: #f3f3f3;">
        @foreach ($page->sponsors as $sponsor)
            <img src="{{ asset($sponsor->image) }}" height="80">
        @endforeach
    </div>
@endif
