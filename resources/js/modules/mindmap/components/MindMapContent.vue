<template>
    <div>
        <Layout :style="{minHeight: '85vh'}">
            <Sider :style="{textAlign: 'center'}" collapsible :collapsed-width="78" v-model="isCollapsed">
                <span style="color:white">MindMap: {{ data.name }}</span>
                <Divider>Operate</Divider>
                <Button @click="save">Save</Button>
                <Divider>Node</Divider>
                <Button @click="addNode">Add a child node</Button>
                <Button @click="removeNode">Remove Node</Button>
                <div v-if="selectedNode">
                <Divider>Selected Node</Divider>
                    <div style="color:white;">
                        <Col  span="12">
                            Background
                            <ColorPicker v-model="selectedNodeBackgroundColor" />
                        </Col>
                        <Col span="12">
                            Text Color
                            <ColorPicker v-model="selectedNodeForegroundColor" />
                        </Col>
                    </div>
                </div>
                <Divider>MindMap</Divider>
                <Upload action="#" :before-upload="handleUpload">
                    <Button icon="ios-cloud-upload-outline">Load MindMap (.mm)</Button>
                </Upload>
                <Button @click="download">Download (.mm)</Button>
                <Divider>Style</Divider>
                <select v-model="style">
                    <option value="">default</option>
                    <option value="primary">primary</option>
                    <option value="warning">warning</option>
                    <option value="danger">danger</option>
                    <option value="success">success</option>
                    <option value="info">info</option>
                    <option value="greensea" selected="selected">greensea</option>
                    <option value="nephrite">nephrite</option>
                    <option value="belizehole">belizehole</option>
                    <option value="wisteria">wisteria</option>
                    <option value="asphalt">asphalt</option>
                    <option value="orange">orange</option>
                    <option value="pumpkin">pumpkin</option>
                    <option value="pomegranate">pomegranate</option>
                    <option value="clouds">clouds</option>
                    <option value="asbestos">asbestos</option>
                </select>
                <Divider>View</Divider>
                <Button @click="zoomIn">Zoom In</Button>
                <Button @click="zoomOut">Zoom Out</Button>
                <br>
                <Button @click="toggle">Full screen</Button>
                <Button @click="exportImage">ScreenShot</Button>
                <br>
                <Button @click="resize">Resize</Button>
            </Sider>
            <Layout>
                <Content :style="{padding: '0 16px 16px'}">
                    <fullscreen ref="fullscreen" @change="fullscreenChange">
                            <div id="jsmind_container"></div>
                    </fullscreen>
                </Content>
            </Layout>
        </Layout>
    </div>



</template>
<script>
import "jsmind/style/jsmind.css"; 
import jsMind from "jsmind";
global.jsMind = jsMind
require('jsmind/js/jsmind.draggable.js');
require('jsmind/js/jsmind.screenshot.js');
import fullscreen from 'vue-fullscreen'
import Vue from 'vue'
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
    },
    data(){
        return {
            data: {},
            mind: {},
            style: '',
            isCollapsed: false,
            file: null,
            handleUploaded: false,
            fullscreen: false
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
                    this.data = res.data
                    this.mind.show(jsMind.util.json.string2json(res.data.mindmap))
                }
            ).catch(res=>this.mindmap = 'Not Found or No Permission')
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
        save(){
            let submitData = {
                data: {
                    mindmap: jsMind.util.json.json2string(this.mind.get_data())
                }
            }
            axios.put('/mindmaps/'+ this.$route.params.id, submitData).then(
                res => this.$Message.success('Update successful')
            )
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
        zoomIn(){
            if (this.mind.view.zoomIn()) {
                zoomOutButton.disabled = false;
            } else {
                zoomInButton.disabled = true;
            };
        },
        zoomOut(){
            if (this.mind.view.zoomOut()) {
                zoomInButton.disabled = false;
            } else {
                zoomOutButton.disabled = true;
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
                this.mind.set_node_color(this.selectedNode.id, value, this.selectedNodeForegroundColor);
            }
        }
        ,
        selectedNodeForegroundColor: {
            get(){
                return this.selectedNode.data['foreground-color'] || '';
            },
            set(value){
                this.mind.set_node_color(this.selectedNode.id, this.selectedNodeBackgroundColor, value);
            }
        }
        
    },
    watch: {
        style: 'setTheme',
        tmpNode: {
            backgrounColor: 'setColor',
            foregroundColor: 'this.setColor'
        }
    }
}
</script>
<style>
    #jsmind_container {
        height:600px;
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