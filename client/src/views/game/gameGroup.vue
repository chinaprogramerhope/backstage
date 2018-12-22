<template>
  <div>
    <el-row style="text-align: left; margin-bottom:10px; margin-top: 30px">
      <!-- <el-button type="primary">捕鱼游戏</el-button>
      <el-button type="primary">棋牌游戏</el-button>
      <el-button type="primary">电玩街机</el-button> -->

      <el-button type="primary">{{ group[0] }}</el-button>
      <el-button type="primary">{{ group[1] }}</el-button>
      <el-button type="primary">{{ group[2] }}</el-button>
    </el-row>

    <el-table :data="tableData" stripe>
      <el-table-column prop="gameName" label="游戏名称" align="center"/>
      <el-table-column prop="operation" label="操作" align="center"/>
    </el-table>
  </div>
</template>

<script>
import { groupGet } from '@/api/game'

export default {
  data() {
    return {
      group: null,
      tableData: [{
        gameName: 111,
        operation: 'xxx1'
      }, {
        gameName: 112,
        operation: 'xxx2'
      }]
    }
  },
  created() {
    this.getGroup()
  },
  methods: {
    getGroup() {
      groupGet().then(response => {
        // test
        console.log('ok11, respose = ' + JSON.stringify(response.data))
        this.group = response.data
      })
    }
  }
}
</script>

