<template>
  <div>

    <!-- 表单 -->
    <el-form :inline="true" :model="form1" align="left" style="margin-top: 30px">
      <el-form-item label="时间:">
        <el-date-picker
          v-model="form1.dpValue1"
          type="daterange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
        />
      </el-form-item>
      <el-form-item label="游戏名称:">
        <el-select v-model="form1.selectGameName">
          <el-option
            v-for="item in form1.optionsGameName"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="游戏房间:">
        <el-select v-model="form1.selectGameRoom">
          <el-option
            v-for="item in form1.optionsGameRoom"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="玩家id:">
        <el-input v-model="form1.userId" clearable/>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onSubmit">查询 (默认显示最近30天)</el-button>
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
      <el-table-column prop="userScoreBegin" label="开始金币" sortable align="center"/>
      <el-table-column prop="userScoreEnd" label="结束金币" sortable align="center"/>
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

    <!-- <el-row>
      <el-col :span="10" style="text-align: right">
        总下注金额&nbsp;&nbsp;<el-tag>11.11元</el-tag>&nbsp;&nbsp;
        总中奖金额&nbsp;&nbsp;<el-tag>11.11元</el-tag>&nbsp;&nbsp;
        总盈亏金额&nbsp;&nbsp;<el-tag>11.11元</el-tag>&nbsp;&nbsp;
        总税收金额&nbsp;&nbsp;<el-tag>11.11元</el-tag>
      </el-col>
    </el-row> -->
  </div>
</template>

<script>
import { betRecordGet } from '@/api/game'

export default {
  data() {
    return {
      form1: {
        selectGameName: -1,
        selectGameRoom: -1,
        userId: '',
        dpValue1: '',
        optionsGameName: [{
          label: '全部',
          value: -1
        }, {
          label: '德州扑克',
          value: 1
        }, {
          'label': '抢庄牛牛',
          'value': 18
        }, {
          label: '看牌牛牛',
          value: 20
        }, {
          label: '百人牛牛',
          value: 21
        }, {
          label: '炸金花',
          value: 49
        }, {
          label: '红黑大战',
          value: 52
        }, {
          label: '经典斗地主',
          value: 97
        }, {
          label: '欢乐斗地主',
          value: 98
        }, {
          label: '十三水',
          value: 161
        }, {
          label: '十三水_5色',
          value: 162
        }, {
          label: '跑得快',
          value: 321
        }, {
          label: '奔驰宝马',
          value: 350
        }, {
          label: '龙虎斗',
          value: 351
        }, {
          label: '百家乐',
          value: 352
        }],
        optionsGameRoom: [{
          label: '全部',
          value: -1
        }, {
          label: '小资场',
          value: 0
        }, {
          label: '老板场',
          value: 1
        }, {
          label: '土豪场',
          value: 2
        }]
      },

      // tableData
      tableData: '',

      // 分页
      currentPage: 4
    }
  },

  created() {
    betRecordGet(this.form1.dpValue1, this.form1.selectGameName, this.form1.selectGameRoom, this.form1.userId).then(response => {
      this.tableData = response.data
    })
  },

  methods: {
    onSubmit() {
      betRecordGet(this.form1.dpValue1, this.form1.selectGameName, this.form1.selectGameRoom, this.form1.userId).then(response => {
        this.tableData = response.data
      })
    },

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    }
  }
}
</script>
