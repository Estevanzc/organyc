<script setup>
import marmotaImg from "../../assets/marmtoa.webp"
import teamImg from "../../assets/team.jpeg"
import Collapsible from "../Components/Collapsible.vue";

</script>

<template>
    <div :style="`background-image: url(${marmotaImg});`"
        class="relative w-full h-[45vh] bg-fixed bg-cover bg-no-repeat bg-position-[center_30%] overflow-hidden">
    </div>

    <div class="main-content-collapsible flex flex-col items-center py-12">
        <collapsible>
            <template #header>
                <h1>Sobre</h1>
            </template>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores dolorum nihil at molestiae. Quasi et perspiciatis deleniti adipisci eligendi nostrum rem provident fuga, iure nisi doloribus dolorum, hic sit quibusdam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit aperiam autem, quam architecto minus repellendus asperiores odio optio nam molestias aut sapiente, officiis consequuntur placeat corrupti ipsam incidunt eaque accusamus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus quod itaque minima provident obcaecati maiores, aliquam harum maxime ipsa facilis! Placeat ipsum id in rerum repellendus aliquid inventore odit optio? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure debitis, magnam fugit itaque quis quidem sint eaque ducimus natus dignissimos! Ratione labore porro laboriosam molestias est deserunt accusamus quod fugiat?</p>
        </collapsible>

        <collapsible>
            <template #header>
                <h1>Objetivo</h1>
            </template>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores dolorum nihil at molestiae. Quasi et perspiciatis deleniti adipisci eligendi nostrum rem provident fuga, iure nisi doloribus dolorum, hic sit quibusdam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit aperiam autem, quam architecto minus repellendus asperiores odio optio nam molestias aut sapiente, officiis consequuntur placeat corrupti ipsam incidunt eaque accusamus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus quod itaque minima provident obcaecati maiores, aliquam harum maxime ipsa facilis! Placeat ipsum id in rerum repellendus aliquid inventore odit optio? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure debitis, magnam fugit itaque quis quidem sint eaque ducimus natus dignissimos! Ratione labore porro laboriosam molestias est deserunt accusamus quod fugiat?</p>
        </collapsible>

        <collapsible>
            <template #header>
                <h1>Equipe</h1>
            </template>

            <div class="team-container flex justify-between gap-2">
                <div class="img-wrapper w-1/2">
                    <div class="h-[450px] w-fit rounded-xl overflow-hidden">
                        <img :src="teamImg" alt="Foto do time" class="aspect-square object-cover object-bottom" />
                    </div>
                </div>
                <div class="presentation-wrapper w-1/2 h-full p-6">
                    <h1 class="text-5xl text-lime-500 font-bold pb-8">Bem vindo, usuário!</h1>
                    <p class="text-2xl pl-4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eum dolorem molestias nobis obcaecati blanditiis tempore voluptatem quo nisi eius accusantium. Accusamus dolorum aut perferendis error alias doloremque quam doloribus veniam? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorum blanditiis, quae error nesciunt facere harum sint aut dolorem beatae quia iusto consequuntur deserunt minima excepturi fugit id officiis, sunt mollitia. Oi Jaques, se vc tá vendo isso eu sou seu maior fã ~Ale</p>
                </div>
            </div>

        </collapsible>

        <collapsible>
            <template #header>
                <h1>Como Usar</h1>
            </template>

        </collapsible>
    </div>
</template>