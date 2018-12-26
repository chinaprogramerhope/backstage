<template>
  <div>
    <el-form :inline="true" :model="form1" class="demo-form-inline" align="left" style="margin-top: 30px">
      <el-form-item label="游戏名称:">
        <el-input v-model="form1.gameName"/>
      </el-form-item>
      <el-form-item label="游戏状态:">
        <el-select v-model="form1.gameStatus">
          <el-option
            v-for="item in optionsGameStatus"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="游戏类型:">
        <el-select v-model="form1.gameType">
          <el-option
            v-for="item in optionsGameType"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onSubmit">搜索</el-button>
      </el-form-item>
    </el-form>

    <el-table :data="tableData" stripe style="margin-bottom: 24px">
      <el-table-column label="游戏名称" prop="gameName" align="center"/>
      <el-table-column label="游戏类型" align="center">
        <template slot-scope="scope">
          <el-tag size="medium">{{ scope.row.gameType }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="游戏状态" align="center">
        <template slot-scope="scope">
          <el-tag type="success" size="medium">{{ scope.row.gameStatus }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="维护时间" prop="maintainTime" align="center"/>
      <el-table-column label="操作" prop="operation" align="center">
        <template slot-scope="scope">
          <el-button type="primary" plain size="mini" @click="handleRoom()">房间</el-button>
          <el-button size="mini" @click="handleEdit()">编辑</el-button>
        </template>
      </el-table-column>
    </el-table>

    <el-pagination
      :current-page="currentPage"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="10"
      :total="40"
      layout="total, sizes, prev, pager, next, jumper"
      align="center"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    />
  </div>
</template>

<script>
import { listGet } from '@/api/game'

var gameName = ''
var gameType = -1
var gameStatus = -1

export default {
  data() {
    return {
      form1: {
        gameName: '',
        gameStatus: '全部',
        gameType: '全部'
      },

      // optionsGameStatus
      optionsGameStatus: [{
        'label': '全部',
        'value': -1
      }, {
        'label': '正常',
        'value': 1
      }, {
        'label': '禁用',
        'value': 2
      }, {
        'label': '维护中',
        'value': 3
      }],

      // optionsGameType
      optionsGameType: [{
        'label': '全部',
        'value': -1
      }, {
        'label': '下注类',
        'value': 1
      }, {
        'label': '捕鱼类',
        'value': 2
      }, {
        'label': '对战类',
        'value': 3
      }],

      // tableData
      tableData: null,

      // 分页
      currentPage: 4
    }
  },

  created() {
    this.listGetClient(gameName, gameType, gameStatus)
  },

  methods: {
    listGetClient(gameName, gameType, gameStatus) {
      listGet(gameName, gameType, gameStatus).then(response => {
        this.tableData = response.data
        // test
        console.log('resData = ' + JSON.stringify(response.data))
      })
    },

    onSubmit() {
      console.log('name = ' + this.form1.gameName + ', type = ' + this.form1.gameType + ', status = ' + this.form1.gameType)
      this.listGetClient(this.form1.gameName, this.form1.gameType, this.form1.gameType)
    },

    // 分页
    handleSizeChange(val) {
    },
    handleCurrentChange(val) {

    }
  }
}
</script>
