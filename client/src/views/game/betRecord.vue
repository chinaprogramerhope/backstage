<template>
  <div>

    <!-- 表单 -->
    <el-form :inline="true" :model="form1" align="left" style="margin-top: 30px">
      <el-form-item label="时间:">
        <el-date-picker
          v-model="dpValue1"
          type="daterange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
        />
      </el-form-item>
      <el-form-item label="游戏名称:">
        <el-select v-model="form1.gameName">
          <el-option
            v-for="item in optionsGameName"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="游戏房间:">
        <el-select v-model="form1.gameRoom">
          <el-option
            v-for="item in optionsGameRoom"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="玩家id:">
        <el-input v-model="form1.userId"/>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onSubmit">查询</el-button>
      </el-form-item>
    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="userId" label="玩家id" sortable align="center"/>
      <el-table-column prop="userNickname" label="玩家昵称" sortable align="center"/>
      <el-table-column prop="gameName" label="游戏名称" sortable align="center"/>
      <el-table-column prop="roomName" label="游戏房间" sortable align="center"/>
      <el-table-column prop="gameNumber" label="牌局编号" sortable align="center"/>
      <el-table-column prop="userGameResult" label="输赢状态" sortable align="center"/>
      <el-table-column prop="userTableFee" label="桌费" sortable align="center"/>
      <el-table-column prop="userScoreBegin" label="开始金豆" sortable align="center"/>
      <el-table-column prop="userScoreEnd" label="结束金豆" sortable align="center"/>
      <el-table-column prop="gameTime" label="游戏时长" sortable align="center"/>
      <el-table-column prop="recordTimestamp" label="游戏时间" sortable align="center"/>
      <!-- <el-table-column prop="operation" label="操作" sortable align="center">
        <template slot-scope="scope">
          <el-button type="text" @click="handleDetail()">详细</el-button>
        </template>
      </el-table-column> -->
    </el-table>

    <!-- 分页 -->
    <!-- <el-row gutter="20">
      <el-col :span="10" style="text-align: center">
        <el-pagination
          :current-page="currentPage"
          :page-sizes="[10, 20, 30, 40]"
          :page-size="10"
          :total="40"
          layout="total, sizes, prev, pager, next, jumper"
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
        />
      </el-col> -->

    <el-row>
      <el-col :span="10" style="text-align: right">
        总下注金额&nbsp;&nbsp;<el-tag>11.11元</el-tag>&nbsp;&nbsp;
        总中奖金额&nbsp;&nbsp;<el-tag>11.11元</el-tag>&nbsp;&nbsp;
        总盈亏金额&nbsp;&nbsp;<el-tag>11.11元</el-tag>&nbsp;&nbsp;
        总税收金额&nbsp;&nbsp;<el-tag>11.11元</el-tag>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // 日期(不在这里返回会不显示选择的时间)
      dpValue1: '',

      form1: {
        gameName: '全部',
        gameRoom: '全部',
        userId: ''
      },

      // optionsGameName
      optionsGameName: [{
        'label': '全部',
        'value': 'all'
      }, {
        'label': '斗地主',
        'value': 'douidizhu'
      }, {
        'label': '牛牛',
        'value': 'niuniu'
      }, {
        'label': '红黑大战',
        'value': 'honghei'
      }, {
        'label': '全部',
        'value': 'all'
      }, {
        'label': '斗地主',
        'value': 'douidizhu'
      }, {
        'label': '牛牛',
        'value': 'niuniu'
      }, {
        'label': '红黑大战',
        'value': 'honghei'
      }, {
        'label': '全部',
        'value': 'all'
      }, {
        'label': '斗地主',
        'value': 'douidizhu'
      }, {
        'label': '牛牛',
        'value': 'niuniu'
      }, {
        'label': '红黑大战',
        'value': 'honghei'
      }],

      // optionsGameRoom
      optionsGameRoom: [{
        'label': '全部',
        'value': 'all'
      }, {
        'label': '初级房',
        'value': 'junior'
      }, {
        'label': '中级房',
        'value': 'middle'
      }, {
        'label': '高级房',
        'value': 'advance'
      }, {
        'label': '富豪房',
        'value': 'rich'
      }, {
        'label': '至尊房',
        'value': 'Supreme'
      }],

      // tableData
      tableData: [{
        timeBegin: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        userId: 'ok1',
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }, {
        timeBegin: '2018-11-11 11:11:12',
        timeEnd: '2018-11-11 11:11:12',
        userId: 'ok2',
        gameName: '牛牛2',
        gameRoom: '初级房',
        bet: 11.12,
        winAmount: 11.12,
        winLose: 11.12,
        tax: 11.12
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
