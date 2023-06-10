<div class="w-100 navbar text-light p-3 footer">
    <div class="container">
        <div class="row py-4 w-100">
            @foreach ($firstBanners as $b)
                <div class="col-12 col-md-6 col-lg-3 footerSection mt-3 mb-5 mb-lg-0">
                    <p class="text-light footerSectionTitle usePoppins text-muted">{{ $b['title'] }}</p>
                    @foreach ($b['itemList'] as $item)
                        @if (isset($item['tooltip']))
                            <p class="text-light footerSectionP" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="{{ $item['tooltip'] }}">
                            @else
                            <p class="text-light footerSectionP">
                        @endif
                        @if (!array_key_exists('url', $item))
                            {{ $item['title'] }}
                        @else
                            @if ($item['isInternal'])
                                <a href="{{ route($item['url']) }}">{{ $item['title'] }}</a>
                            @else
                                <a href="{{ $item['url'] }}" target="_blank">{{ $item['title'] }}</a>
                            @endif
                        @endif
                        </p>
                    @endforeach
                </div>
            @endforeach
            <div class="col align-self-center">
                <a target="_blank" href="{{ $sites[0]['link'] }}"><img
                        src="{{ asset(env('PATH_BASE') . 'images/logo-lampehCut.webp') }}"
                        alt="Logo Arqueológia" class="img-fluid"></a>
            </div>

        </div>
        <div class="row mt-4 w-100 align-items-center">
            <div class="col-12 col-lg-5">
                <p class="footerSiteTitle p-3">Patrimõnio Arqueológico</p>
            </div>
            <div class="col footerAnotherSites">
                <div class="d-flex justify-content-center justify-content-lg-end">
                    {{-- <a class="p-3 footerAnotherSitesP" href="{{ route('contactUs') }}">Fale Conosco</a> --}}
                    @foreach ($sites as $site)
                        <a class="p-3 footerAnotherSitesP" target="_blank"
                            href="{{ $site['link'] }}">{{ $site['title'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="justify-content-center justify-content-lg-start mt-5 w-100 copyrightSection">
            <span>Copyright © LAMPEH {{ \Carbon\Carbon::now()->year }} — Todos os direitos reservados</span>
        </div>
    </div>
</div>
