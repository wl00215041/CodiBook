<template>
    <div id="nav">
        <Row>
            <Col span="24">
                <Menu mode="horizontal" :theme="theme1" active-name="1">
                    <MenuItem name="1" :to="{name: 'home'}">
                        <Icon type="ios-paper" />
                        Book
                    </MenuItem>
                    <MenuItem name="2" :to="{name: 'mindmap'}">
                        <Icon type="ios-people" />
                        MindMap
                    </MenuItem>
                    <MenuItem name="3" :to="{ name: 'bookCreate' }">
                        <Icon type="ios-paper" />
                        Create
                    </MenuItem>
                </Menu>        
            </Col>
        </Row>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                theme1: 'light'
            }
        }
    }
</script>
<style>
#nav {
    text-align: left;
}
</style>
