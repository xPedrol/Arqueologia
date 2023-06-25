<x-layout title="Quem somos" description="Patrimônio Arqueológico é um site criado e mantido por pesquisadores dedicados aos estudos e
                    pesquisas desta área de conhecimento. É fruto do convênio estabelecido entre a Universidade Federal
                    de Viçosa e a empresa Vale S. A.">
    <x-slot name="content">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sobre</li>
                </ol>
            </nav>
            <div style="font-size: 17px">
                <p>Patrimônio Arqueológico é um site criado e mantido por pesquisadores dedicados aos estudos e
                    pesquisas desta área de conhecimento. É fruto do convênio estabelecido entre a Universidade Federal
                    de Viçosa e a empresa Vale S. A., que tem como um de seus resultados a criação do <a
                        href="https://posarqueologia.ufv.br/" target="_blank">Curso de Especialização em Preservação e
                        Difusão de
                        Estruturas e Sítios Arqueológicos a Céu Aberto</a>, em 2022.</p>


                <p></p>


                <p>Os pesquisadores envolvidos no convênio criaram este site para reunir pessoas interessadas nesta área
                    do conhecimento, disponibilizar fontes, bibliografia, notícias e outros materiais que possam
                    interessar não apenas aos alunos do curso de especialização, mas a todos os interessados na
                    Arqueologia.</p>


                <p>Alguns conteúdos específicos serão oferecidos apenas às pessoas que se registrarem no site. Elas
                    poderão, se desejarem, divulgar o currículo através dele e ter acesso a fontes documentais,
                    bibliografia e outros materiais.</p>


                <p>O site está em desenvolvimento, o que significa que sofrerá modificações com o avançar do tempo.
                    Portanto, as críticas e sugestões são muito bem vindas, pois nos ajudarão a melhorá-lo. Utilize o <a
                        href="{{route('contact')}}" data-type="page" data-id="8">Fale Conosco</a>
                    para enviá-las.</p>
            </div>
        </div>
    </x-slot>
</x-layout>
