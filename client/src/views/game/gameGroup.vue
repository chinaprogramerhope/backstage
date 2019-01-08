<template>
  <div>
    <el-row style="text-align: left; margin-bottom:10px; margin-top: 30px">

      <el-button
        v-for="(item,key) in group"
        :key="key"
        type="primary"
        @click="groupGetGamesClient(key)"
      >
        {{ item }}
      </el-button>

    </el-row>

    <el-table :data="tableData" stripe>
      <el-table-column prop="gameName" label="游戏名称" align="center"/>
      <el-table-column prop="operation" label="操作" align="center">
        <!-- <template slot-scope="scope">
          <el-button size="mini" @click="setTop()">设为置顶</el-button>
          <el-button size="mini" @click="cancelTop()">取消热门</el-button>
        </template> -->
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { groupGet } from '@/api/game'
import { groupGetGames } from '@/api/game'

var groupId = 1

export default {
  data() {
    return {
      group: null,
      tableData: null
    }
  },
  created() {
    this.groupGetClient()
    this.groupGetGamesClient(groupId)
  },
  methods: {
    groupGetClient() {
      groupGet().then(response => {
        this.group = response.data
      })
    },

    groupGetGamesClient(groupId) {
      groupGetGames(groupId).then(response => {
        this.tableData = response.data
      })
    }
  }
}
</script>
