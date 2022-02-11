<template>
    <div>
        <div class="container-header">
            <div id="logo">
                <a href="/" title="Институт цифровых технологий, электроники и физики АлтГУ"
                   rel="home">
                    <h1 class="site-title">ИЦТЭФ</h1>

                </a>
            </div>


            <div class="btn-outline-primary">ОБ ИНСТИТУТЕ</div>
            <div class="btn-outline-primary"><a href="http://phys.asu/абитуриентам/">АБИТУРИЕНТАМ</a></div>
            <div class="btn-outline-primary">СТУДЕНТАМ</div>
            <div class="btn-outline-primary">НАУКА</div>
            <div class="btn-outline-primary">ПАРТНЕРЫ</div>
            <div class="btn-outline-primary">ДПО</div>

            <form role="search" method="get" class="search-form" action="http://phys.asu.ru/">
                <label>
                    <span class="screen-reader-text">Найти:</span>
                    <input type="search" class="search-field" placeholder="Поиск…" value="" name="s"
                           control-id="ControlID-1">
                </label>
                <input type="submit" class="search-submit" value="Поиск" control-id="ControlID-2">
            </form>
        </div>
        <hr/>


        <div>

        </div>


        <div>

        </div>

        <footer class="site-footer"></footer>
    </div>
</template>

<script>
export default {
    name: "TemplateComponent",
    components: {},
    props: {
        data: Object,
    },
    data: () => {
        return {
            pageData: 0,
        }
    },
    mounted() {
        console.log(this.data)
    },

}
</script>
<style lang="scss">
.container-header {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;

    div {
        padding: 20px 40px;
    }
}

.container-header + hr {
    width: 100%;
    align: center;
}

.site-footer {
    background-color: #26272b;
    padding: 45px 0 10px;
    font-size: 15px;
    line-height: 24px;
    color: #737373;
}
</style>

