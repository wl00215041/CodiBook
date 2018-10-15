<template>
    <div>
        <div id="jsmind_container"></div>
    </div>
</template>
<script>
import "jsmind/style/jsmind.css"; 
import jsMind from "jsmind";
global.jsMind = jsMind
require('jsmind/js/jsmind.draggable.js');
export default {
    mounted() {
        this.mind = {
           "meta":{
                "name":"demo",
                "author":"hizzgdev@163.com",
                "version":"0.2",
            },
            "format":"node_array",
            "data":[
                {"id":"root", "isroot":true, "topic":"jsMind"},
            ]
        };
        var options = {
            container:'jsmind_container',
            theme:'orange',
            editable:true
        };
        var jm = new jsMind(options);
        jm.show(this.mind);
    },
    data(){
        return {
            mind: {}
        }
    }
}
</script>
<style>
#jsmind_container {
    height: 800px;
    width: 100%;
}
</style>