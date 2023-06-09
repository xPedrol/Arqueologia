<x-layout :title="'Home'">
    <x-slot name="content">
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/images/1.jpeg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/2.jpeg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/3.jpeg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/6.jpeg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/4.jpeg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/5.jpeg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/7.jpeg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="/images/8.jpeg" class="d-block w-100" alt="...">
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
                    <div class="text-center">
                        <a class="btn btn-dark" href="{{ route('register') }}">Registrar</a>
                    </div>
                </div>
                <div class="col-3">
                    <div class="d-flex flex-column">
                        <h5 class="usePoppins">Destaques</h5>
                        <hr>
                        <p class="m-0">Curso de Especialização</p>
                        <p class="m-0">Canal no youtube</p>
                    </div>
                    <div class="d-flex flex-column mt-5">
                        <h5 class="usePoppins">Apoio</h5>
                        <hr>
                        <img src="https://arqueologia.lampeh.ufv.br/wp-content/uploads/2022/08/indice-1.jpg"
                            class="mb-4" alt="" width="100%">
                        <img src="https://arqueologia.lampeh.ufv.br/wp-content/uploads/2022/08/lampeh-1.jpg"
                            alt="" width="100%" class="mb-4">
                        <img src="/images/logotipoUfv.jpg" alt="" width="100%">
                    </div>
                </div>
            </div>

        </div>
    </x-slot>
</x-layout>
