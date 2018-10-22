<template>
    <div id="nav">
        <Row>
            <Col span="24">
                <Menu mode="horizontal" :theme="theme1" :active-name="$router.currentRoute.name">
                    <MenuItem name="home" :to="{name: 'home'}">
                        <Icon type="ios-paper" />
                        Book
                    </MenuItem>
                    <MenuItem name="mindmapList" :to="{name: 'mindmapList'}">
                        <Icon type="ios-people" />
                        MindMap
                    </MenuItem>
                    <MenuItem name="bookCreate" :to="{ name: 'bookCreate' }">
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
