<template>
  <AppCard variant="screen" class="tw-p-8">
    <div class="content-container">
      <h1>Bem-vindos(as) ao Glossário Multimídia de Logística em Libras!</h1>
      <br />
      <p>
        Este portal foi criado para facilitar o aprendizado de termos técnicos da área de Logística
        por estudantes surdos e ouvintes. Aqui, você encontrará vídeos em Libras legendados com o
        sinal de cada termo, a definição e os exemplos práticos, abordando conteúdos que promovem a
        inclusão, o conhecimento e o acesso à educação profissional de forma mais acessível e
        significativa.
      </p>
      <br />
      <p>
        Desenvolvido no IFPE – Campus Igarassu, tendo a participação dos estudantes surdos do curso
        Técnico em Logística Bruna Lopes Cabral e Katsson Dalas de lima que, juntamente com as
        intérpretes de libras, Celivane de Lima Silva de Souza, Joana Kelly Correia de Lucena da
        Silva Rosas e os estudantes do curso Tecnologia de Sistemas, Claudiane Rodrigues, Guilherme
        Valença e Weydson Lino, se debruçaram incansavelmente nas demandas de desenvolvimento do
        trabalho aqui apresentado.
      </p>
      <br />
      <p>
        Esperamos que esta ferramenta contribua para sua jornada de aprendizado e fortaleça a
        inclusão de todos no mundo da Logística!
      </p>
      <br />
      <p>
        <strong>Boa navegação e bons estudos!</strong>
      </p>
      <br />
      <client-only>
        <iframe
            class="medium-iframe"
            src="https://www.youtube.com/embed/4Z-P3qQDPbo"
            allowfullscreen
        />
      </client-only>
    </div>
  </AppCard>
</template>

<script lang="ts" setup>
import useBreadcrumbStore from '~/stores/useBreadcrumbStore';

onMounted(() => {
  useBreadcrumbStore().activeAbout();
});
</script>
