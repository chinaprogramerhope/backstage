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
      <el-table-column label="游戏类型" prop="gameType" align="center"/>
      <el-table-column label="游戏状态" prop="gameStatus" align="center"/>
      <el-table-column label="维护时间" prop="maintainTime" align="center"/>
      <el-table-column label="操作" prop="operation" align="center">
        <template slot-scope="scope">
          <el-button type="text" @click="handleRoom()">房间</el-button>
          <el-button type="text" @click="handleEdit()">编辑</el-button>
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
        'value': 'all'
      }, {
        'label': '正常',
        'value': 'normal'
      }, {
        'label': '禁用',
        'value': 'forbid'
      }, {
        'label': '维护中',
        'value': 'maintain'
      }],

      // optionsGameType
      optionsGameType: [{
        'label': '全部',
        'value': 'all'
      }, {
        'label': '下注类',
        'value': 'bet'
      }, {
        'label': '捕鱼类',
        'value': 'fish'
      }, {
        'label': '对战类',
        'value': 'battle'
      }],

      // tableData
      tableData: [{
        gameName: '牛牛',
        gameType: '棋牌游戏',
        gameStatus: '正常',
        maintainTime: '无~无'
      }, {
        gameName: '牛牛',
        gameType: '棋牌游戏',
        gameStatus: '正常',
        maintainTime: '无~无'
      }, {
        gameName: '牛牛',
        gameType: '棋牌游戏',
        gameStatus: '正常',
        maintainTime: '无~无'
      }, {
        gameName: '牛牛',
        gameType: '棋牌游戏',
        gameStatus: '正常',
        maintainTime: '无~无'
      }],

      // 分页
      currentPage: 4
    }
  },
  methods: {
    obSubmit() {
      console.log('submit!')
    },

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    }
  }
}
</script>
