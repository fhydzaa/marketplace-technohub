<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Bootstrap demo</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="{{ asset('front-assets/style.css') }}" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>
    <body>
        <div
            class="container col-md-12"
            id="reviews"
            aria-labelledby="reviews-tab"
        >
            <button
                class="btn btn-secondary"
                style="background-color: #123159; color: white"
                onclick="goBack()"
            >
                Back
            </button>
            <br /><br />
            <!-- <div>
                <div class="overall-rating mb-3">
                    <h3 class="h4 pb-3">Ulasan Produk</h3>
                    <div class="d-flex align-items-center">
                        <h1 class="h3 pe-3 mb-0">{{ $avgRating }}</h1>
                        <div
                            class="star-rating mt-0"
                            title="{{ $avgRatingPer }}%"
                        >
                            <div class="back-stars">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <div
                                    class="front-stars"
                                    style="width: {{ $avgRatingPer }}%"
                                >
                                    <i
                                        class="fa fa-star"
                                        aria-hidden="true"
                                    ></i>
                                    <i
                                        class="fa fa-star"
                                        aria-hidden="true"
                                    ></i>
                                    <i
                                        class="fa fa-star"
                                        aria-hidden="true"
                                    ></i>
                                    <i
                                        class="fa fa-star"
                                        aria-hidden="true"
                                    ></i>
                                    <i
                                        class="fa fa-star"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2 ps-2">
                            ({{ ($product->product_ratings_count > 1) ? $product->product_ratings_count.' Reviwes' : $product->product_ratings_count.' Reviews'




                            }})
                        </div>
                    </div>
                </div>
                <div class="rating-group mb-4 ps-5">
                    @if($product->product_ratings->isNotEmpty())
                    @foreach($product->product_ratings as $key => $rating) @php
                    $ratingPer = ($rating->rating * 100) / 5; @endphp
                    <div class="rating-group mb-4">
                        <span class="author"
                            ><strong>{{ $rating->username }}</strong></span
                        >
                        <div class="star-rating mt-2">
                            <div class="back-stars">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <div
                                    class="front-stars"
                                    style="width: {{ $ratingPer }}%"
                                >
                                    <i
                                        class="fa fa-star"
                                        aria-hidden="true"
                                    ></i>
                                    <i
                                        class="fa fa-star"
                                        aria-hidden="true"
                                    ></i>
                                    <i
                                        class="fa fa-star"
                                        aria-hidden="true"
                                    ></i>
                                    <i
                                        class="fa fa-star"
                                        aria-hidden="true"
                                    ></i>
                                    <i
                                        class="fa fa-star"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                        </div>
                        <div class="my-3">
                            <p>{{ $rating->comment }}</p>
                        </div>
                    </div>
                    @endforeach @endif
                </div>
            </div> -->
            @if(Auth::check())
            <hr class="mt-2" style="width: 100%" />
            <div class="col-md-8">
                <h3 class="h4 pb-3">Tulis Ulasan</h3>
                <div class="row ps-5">
                    <form
                        action=""
                        name="productRatingForm"
                        id="productRatingForm"
                        method="post"
                    >
                        @csrf

                        <div class="form-group col-md-6 mb-3">
                            <label for="name">Name</label>
                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                placeholder="Name"
                                value="{{ $user->name }}"
                            />

                            <p></p>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="email">Email</label>
                            <input
                                type="text"
                                class="form-control"
                                name="email"
                                id="email"
                                value="{{ $user->email }}"
                                readonly
                            />

                            <p
                                class="text-muted mt-2"
                                style="font-size: 0.875em; font-style: italic"
                            >
                                *Email Anda tidak akan ditampilkan di review.
                            </p>
                        </div>

                        <div class="form-group mb-3">
                            <label for="rating">Rating</label>
                            <br />
                            <div class="rating" style="width: 10rem">
                                <input
                                    id="rating-5"
                                    type="radio"
                                    name="rating"
                                    value="5"
                                />
                                <label for="rating-5"
                                    ><i class="fas fa-3x fa-star"></i
                                ></label>
                                <input
                                    id="rating-4"
                                    type="radio"
                                    name="rating"
                                    value="4"
                                />
                                <label for="rating-4"
                                    ><i class="fas fa-3x fa-star"></i
                                ></label>
                                <input
                                    id="rating-3"
                                    type="radio"
                                    name="rating"
                                    value="3"
                                />
                                <label for="rating-3"
                                    ><i class="fas fa-3x fa-star"></i
                                ></label>
                                <input
                                    id="rating-2"
                                    type="radio"
                                    name="rating"
                                    value="2"
                                />
                                <label for="rating-2"
                                    ><i class="fas fa-3x fa-star"></i
                                ></label>
                                <input
                                    id="rating-1"
                                    type="radio"
                                    name="rating"
                                    value="1"
                                />
                                <label for="rating-1"
                                    ><i class="fas fa-3x fa-star"></i
                                ></label>
                            </div>
                            <p class="product-rating-error text-danger"></p>
                        </div>
                        <div class="form-group mb-3">
                            <label for="comment"
                                >How was your overall experience?</label
                            >
                            <textarea
                                name="comment"
                                id="comment"
                                class="form-control"
                                cols="30"
                                rows="10"
                                placeholder="How was your overall experience?"
                            ></textarea>
                            <p></p>
                        </div>
                        <div>
                            <button
                                class="btn btn-dark mb-5"
                                style="background-color: #123159; color: white"
                            >
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"
        ></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            $("#productRatingForm").submit(function (event) {
                event.preventDefault();
                $.ajax({
                    url: '{{ route("front.saveRating", $product->id) }}',
                    type: "post",
                    data: $(this).serializeArray(),
                    dataType: "json",
                    success: function (response) {
                        var errors = response.errors;

                        if (response.status == false) {
                            if (errors.name) {
                                $("#name")
                                    .siblings("p")
                                    .addClass("invalid-feedback")
                                    .html(errors.name);
                                $("#name").addClass("is-invalid");
                            } else {
                                $("#name")
                                    .siblings("p")
                                    .removeClass("invalid-feedback")
                                    .html("");
                                $("#name").addClass("is-invalid");
                            }

                            if (errors.email) {
                                $("#email")
                                    .siblings("p")
                                    .addClass("invalid-feedback")
                                    .html(errors.email);
                                $("#email").addClass("is-invalid");
                            } else {
                                $("#email")
                                    .siblings("p")
                                    .removeClass("invalid-feedback")
                                    .html("");
                                $("#email").addClass("is-invalid");
                            }

                            if (errors.comment) {
                                $("#comment")
                                    .siblings("p")
                                    .addClass("invalid-feedback")
                                    .html(errors.comment);
                                $("#comment").addClass("is-invalid");
                            } else {
                                $("#comment")
                                    .siblings("p")
                                    .removeClass("invalid-feedback")
                                    .html("");
                                $("#comment").addClass("is-invalid");
                            }

                            if (errors.rating) {
                            } else {
                            }
                        } else {
                            window.location.href =
                                "{{ route('front.product', $product->slug) }}";
                        }
                    },

                    error: function (xhr, status, error) {},
                });
            });
        </script>
    </body>
</html>
