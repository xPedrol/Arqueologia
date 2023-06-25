<x-layout title="home">
    <x-slot name="content">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-9">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/images/1.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/2.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/3.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/6.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/4.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/5.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/7.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/8.webp" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                                data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                                data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <hr>
                    <p class="mt-4" style="font-size: 17px">Patrimônio Arqueológico é um site criado e mantido pela
                        Universidade Federal de
                        Viçosa (MG), com
                        o apoio da empresa Vale S. A.
                        Seu objetivo é reunir interessados nessa área de conhecimento, divulgar oportunidades de estudo
                        e trabalho, publicações, fontes e notícias.</p>
                    <p style="font-size: 17px">Seja membro do grupo! Tenha acesso a conteúdos exclusivos e divulgue seu
                        currículo.</p>
                    @guest
                        <div class="text-center">
                            <a class="btn btn-primary" href="{{ route('register') }}">Registrar</a>
                        </div>
                    @endguest
                </div>
                <div class="col-12 col-lg-3">
                    <div class="d-flex flex-column">
                        <h5 class="usePoppins">Destaques</h5>
                        <hr>
                        <a class="m-0" href="https://posarqueologia.ufv.br/" target="_blank">Curso de Especialização</a>
                        <a class="m-0" href="https://www.youtube.com/channel/UCNqiEO2clT9wvfKSbEYo_fA" target="_blank">Canal no youtube</a>
                    </div>
                    <div class="d-flex flex-column mt-5">
                        <h5 class="usePoppins">Apoio</h5>
                        <hr>
                        <div class="d-none flex-column align-items-center d-lg-flex">
                            <img src="/images/resized/vale.webp"
                                 class="mb-4" alt="" width="100%">
                            <img src="/images/resized/logo-lampehCut.webp"
                                 alt="" width="100%" class="mb-4">
                            <img src="/images/resized/logotipoUfv.webp" alt="" width="100%">
                        </div>
                        <div class="d-flex flex-column align-items-center d-lg-none">
                            <img src="/images/resized/vale.webp"
                                 class="mb-4" alt="" width="60%">
                            <img src="/images/resized/logo-lampehCut.webp"
                                 alt="" width="60%" class="mb-4 d-lg-none">
                            <img src="/images/resized/logotipoUfv.webp" alt="" width="60%">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </x-slot>
</x-layout>
