<template>
    <div>
        <Layout >
            <Layout >
            <div id="toolBar">
                <Tooltip content="Load .mm file">
                    <Upload action="#" :before-upload="handleUpload">
                        <Button><font-awesome icon="folder-open" /></Button>
                    </Upload>
                </Tooltip>
                <Tooltip content="Save">
                    <Button @click="save"><font-awesome icon="save" /></Button>
                </Tooltip>
                |
                <template v-if="selectedNode">
                    <Tooltip content="Add a child node">
                        <Button @click="addNode"><font-awesome icon="plus" /></Button>
                    </Tooltip>
                    <Tooltip content="Remove selected node">
                        <Button @click="removeNode"><font-awesome icon="minus" /></Button>
                    </Tooltip>
                    |
                    <Tooltip content="Move selected node to first">
                        <Button @click="moveToFist"><font-awesome icon="angle-double-up" /></Button>
                    </Tooltip>
                    <Tooltip content="Move selected node to last">
                        <Button @click="moveToLast"><font-awesome icon="angle-double-down" /></Button>
                    </Tooltip>|
                    <Tooltip content="Choose Node background color">
                        <ColorPicker v-model="selectedNodeBackgroundColor" />
                    </Tooltip>
                    <Tooltip content="Choose font color">
                        <ColorPicker v-model="selectedNodeForegroundColor" />
                    </Tooltip>
                </template>
                <Tooltip content="Zoom In">
                    <Button @click="zoomIn"><font-awesome icon="search-plus" /></Button>
                </Tooltip>
                <Tooltip content="Zoom Out">
                    <Button @click="zoomOut"><font-awesome icon="search-minus" /></Button>
                </Tooltip>|
                <Tooltip content="Collapse All">
                    <Button @click="collapseAll"><font-awesome icon="level-down-alt" /></Button>
                </Tooltip>
                <Tooltip content="Expand All">
                    <Button @click="ExpandAll"><font-awesome icon="level-up-alt" /></Button>
                </Tooltip>|
                <Tooltip content="Full Screen">
                    <Button @click="toggle"><font-awesome icon="arrows-alt" /></Button>
                </Tooltip>
                <Tooltip content="Download Mindmap as image">
                    <Button @click="exportImage"><font-awesome icon="camera" /></Button>
                </Tooltip>
                <Tooltip content="Download .mm">
                    <Button @click="download"><font-awesome icon="file-export" /></Button>
                </Tooltip>
                <Tooltip content="Choose MindMap theme" placement="top">
                    <Select v-model="style" style="width:150px">
                        <Option value="''">default</Option>
                        <Option v-for="theme in themes" :value="theme" :key="theme">{{ theme }}</Option>
                    </Select>
                </Tooltip>
            </div>
            </Layout>
            <Layout>
                <Content :style="{padding: '0 16px 16px'}">
                    <fullscreen ref="fullscreen" @change="fullscreenChange">
                            <div id="jsmind_container" :style="{height: (windowHeight-85) + 'px'}"></div>
                    </fullscreen>
                </Content>
            </Layout>
        </Layout>
    </div>
</template>
<script>
import "jsmind/style/jsmind.css"; 
import jsMind from "jsmind";
import fullscreen from 'vue-fullscreen'
import Vue from 'vue'
global.jsMind = jsMind
require('jsmind/js/jsmind.draggable.js');
require('jsmind/js/jsmind.screenshot.js');

Vue.use(fullscreen)
export default {
    mounted() {
        var options = {
            container:'jsmind_container',
            theme:'orange',
            editable:true
        };
        this.mind = new jsMind(options);
        this.getMindMap();
        this.windowHeight = window.innerHeight;
        this.$nextTick(()=>{
            window.addEventListener('resize', ()=>{this.windowHeight = window.innerHeight;});
        })
    },
    data(){
        return {
            data: {},
            mind: {},
            isCollapsed: false,
            file: null,
            handleUploaded: false,
            fullscreen: false,
            windowHeight: 0,
            saved: true,
            themes: [
                'primary',
                'warning',
                'danger',
                'success',
                'info',
                'greensea',
                'nephrite',
                'belizehole',
                'wisteria',
                'asphalt',
                'orange',
                'pumpkin',
                'pomegranate',
                'clouds',
                'asbestos',
            ]
        }
    },
    methods: {
        handleUpload(file){
            this.file = file;
            this.loadFreeMind();
            return this.handleUploaded;
        },
        getMindMap(){
            axios.get('/mindmaps/' + this.$route.params.id).then(
                (res) => {
                    this.data = res.data;
                    this.mind.show(jsMind.util.json.string2json(res.data.mindmap))
                    this.setTheme(this.data.style);
                }
            ).then(()=>{
                this.setLeaveConfirm(false);
            }).catch(res=>this.mindmap = 'Not Found or No Permission')
        },
        addNode(){
            let nodeid = jsMind.util.uuid.newid();
            let topic = '* Node_'+nodeid.substr(0,5)+' *';
            let node = this.mind.add_node(this.selectedNode, nodeid, topic);
        },
        removeNode(){
                if(!this.selectedNode){prompt_info('please select a node first.');return;}
                this.mind.remove_node(this.selectedNode.id);
        },
        moveToFist(){
            this.mind.move_node(this.selectedNode.id,'_first_');
        },
        moveToLast(){
            this.mind.move_node(this.selectedNode.id,'_last_');
        },
        save(){
            let submitData = {
                data: {
                    mindmap: jsMind.util.json.json2string(this.mind.get_data()),
                    style: this.style
                }
            }
            axios.put('/mindmaps/'+ this.$route.params.id, submitData).then(
                res => this.$Message.success('Update successful')
            ).then(()=>this.setLeaveConfirm(false))
        },
        download(){
            let mind_data = this.mind.get_data('freemind');
            let mind_name = this.data.name || 'freemind';
            let mind_str = mind_data.data;
            jsMind.util.file.save(mind_str,'text/xml',mind_name+'.mm');
        },
        exportImage(){
            this.mind.screenshot.shootDownload();
        },
        setTheme(theme){
            this.mind.set_theme(this.style);
        },
        resize(){
            this.mind.resize();
        },
        collapseAll(){
            this.mind.collapse_all();
        },
        ExpandAll(){
            this.mind.expand_all();
        },
        zoomIn(){
            if (this.mind.view.zoomIn()) {
                //zoomOutButton.disabled = false;
            } else {
                //zoomInButton.disabled = true;
            };
        },
        zoomOut(){
            if (this.mind.view.zoomOut()) {
                //zoomInButton.disabled = false;
            } else {
                //zoomOutButton.disabled = true;
            };
        },
        loadFreeMind(){
                jsMind.util.file.read(this.file, (freemind_data, freemind_name) => {
                    if(freemind_data){
                        var mind_name = freemind_name;
                        if(/.*\.mm$/.test(mind_name)){
                            mind_name = freemind_name.substring(0,freemind_name.length-3);
                        }
                        var option = {
                            "meta":{
                                "name":mind_name,
                                "author":"hizzgdev@163.com",
                                "version":"1.0.1"
                            },
                            "format":"freemind",
                            "data":freemind_data
                        };
                        this.mind.show(option);
                    }else{
                        prompt_info('can not open this file as mindmap');
                    }
                });
        },
        setColor(){
            this.mind.set_node_color(this.selectedNode.id, this.tmpNode.backgrounColor, this.tmpNode.foregroundColor);
        },
        toggle () {
            this.$refs['fullscreen'].toggle() // recommended
            // this.fullscreen = !this.fullscreen // deprecated
        },
        fullscreenChange (fullscreen) {
            this.fullscreen = fullscreen
        },
        setLeaveConfirm(needConfirm){
            if(needConfirm){
                window.document.body.onbeforeunload = () => {
                    return "Do you really want to leave? you have unsaved changes!"
                }
                this.saved = false;
            }else{
                window.document.body.onbeforeunload = null;
                this.saved = true;
            }
        }
    },
    computed: {
        menuitemClasses: function () {
            return [
                'menu-item',
                this.isCollapsed ? 'collapsed-menu' : ''
            ]
        },
        selectedNode(){
            try {
                return this.mind.get_selected_node();
            }catch(err){
                return false;
            }
        },
        selectedNodeBackgroundColor: {
            get(){
                return this.selectedNode.data['background-color'] || '';
            },
            set(value){
                Vue.set(this.selectedNode.data, 'background-color', value);
                this.mind.set_node_color(this.selectedNode.id, value, this.selectedNodeForegroundColor);
            }
        },
        selectedNodeForegroundColor: {
            get(){
                return this.selectedNode.data['foreground-color'] || '';
            },
            set(value){
                Vue.set(this.selectedNode.data, 'foreground-color', value);
                this.mind.set_node_color(this.selectedNode.id, this.selectedNodeBackgroundColor, value);
            }
        },
        style: {
            get(){
                return this.data.style;
            },
            set(value){
                this.data.style = value;
                this.setTheme(value);
            }
        },
        mindMapObj(){
            if(Object.keys(this.data).length == 0) return {};
            return this.mind.get_data() || {};
        },
    },
    watch: {
        tmpNode: {
            backgrounColor: 'setColor',
            foregroundColor: 'this.setColor'
        },
        mindMapObj(value) {
            this.saved = false;
            this.setLeaveConfirm(true);
        }
    },
    beforeRouteLeave (to, from , next) {
        if(this.saved === false){
            let confirm = window.confirm('Do you really want to leave? you have unsaved changes!');
            if (confirm) {
                next()
            } else {
                next(false)
            }
            this.setLeaveConfirm(!confirm);
        }else{
            this.setLeaveConfirm(false);
            next();
        }
    }
}
</script>
<style>
    .ivu-upload {
        display: inline-block;
    }
    /*按下面内容修改 jsmind.css 里的内容*/
    /* 16行 */
    jmnodes > input{min-width:420px !important}

    #toolBar {
        font-size: 28px;
    }
    #jsmind_container {
        width: 100%;
    }
    .py-4 {
        padding-top: 0rem !important;
    }
    .layout-con{
        height: 100%;
        width: 100%;
    }
    .menu-item span{
        display: inline-block;
        overflow: hidden;
        width: 69px;
        text-overflow: ellipsis;
        white-space: nowrap;
        vertical-align: bottom;
        transition: width .2s ease .2s;
    }
    .menu-item i{
        transform: translateX(0px);
        transition: font-size .2s ease, transform .2s ease;
        vertical-align: middle;
        font-size: 16px;
    }
    .collapsed-menu span{
        width: 0px;
        transition: width .2s ease;
    }
    .collapsed-menu i{
        transform: translateX(5px);
        transition: font-size .2s ease .2s, transform .2s ease .2s;
        vertical-align: middle;
        font-size: 22px;
    }
    .ivu-btn {
        margin-bottom: 5px;
    }
</style>