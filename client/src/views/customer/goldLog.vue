<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="100px">

      <el-form-item label="游戏:">
        <el-select v-model="form1.selectGame" style="width: 150px">
          <el-option
            v-for="item in form1.optionsGame"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="事件:">
        <el-select v-model="form1.selectEvent" style="width: 150px">
          <el-option
            v-for="item in form1.optionsEvent"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="用户id:">
        <el-input v-model="form1.userId" placeholder="用户id" clearable style="width: 100px"/>
      </el-form-item>

      <el-form-item label="用户账号">
        <el-input v-model="form1.account" placeholder="用户账号" clearable style="width: 150px" disabled/>
      </el-form-item>

      <el-form-item label="时间:">
        <el-date-picker
          v-model="form1.dateTimeRange"
          type="datetimerange"
          range-separator="~"
          start-placeholder="开始时间"
          end-placeholder="结束时间"
          value-format="yyyy-MM-dd HH:mm:ss"
        />
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" @click="handleReset()">重置</el-button>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" icon="el-icon-search" @click="handleExport()">excel导出</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="userid" label="玩家id" align="center"/>
      <el-table-column min-width="10%" prop="chips" label="金豆变化" align="center"/>
      <el-table-column min-width="10%" prop="happentime" label="时间" align="center"/>
      <el-table-column min-width="10%" prop="finalchips" label="结束金豆" align="center"/>
      <el-table-column min-width="10%" prop="originalchips" label="起始金豆" align="center"/>
      <el-table-column min-width="10%" prop="basescore" label="底注" align="center"/>
      <el-table-column min-width="10%" prop="gamecode" label="游戏类型" align="center"/>
      <el-table-column min-width="10%" prop="eventtype" label="事件类型" align="center"/>
      <el-table-column min-width="10%" prop="ipaddress" label="ip" align="center"/>
      <el-table-column min-width="10%" prop="roomid" label="房间id" align="center"/>
      <el-table-column min-width="10%" prop="tableid" label="桌子id" align="center"/>
      <el-table-column min-width="10%" prop="seatid" label="座位id" align="center"/>
    </el-table>

  </div>
</template>

<script>
import { goldLogGet } from '@/api/customer'

export default {
  data() {
    return {
      form1: {
        selectGame: -1,
        optionsGame: [{
          label: '全部',
          value: -1
        }],

        selectEvent: -1,
        optionsEvent: [{
          label: '全部',
          value: -1
        }],

        userId: '',
        accuont: '',
        dateTimeRange: ''
      },

      tableData: [{
        id: '11'
      }],

      tableDataSum: ''
    }
  },

  created() {
    const dateTimeRange = this.form1.dateTimeRange
    const gameId = this.form1.selectGame
    const eventId = this.form1.selectEvent
    const userId = this.form1.userId
    const account = this.form1.account

    goldLogGet(dateTimeRange, gameId, eventId, userId, account).then(response => {
      if (response.code === 0) {
        this.tableData = response.data
      } else {
        this.$notify({
          title: '获取数据失败: ' + response.msg,
          message: '',
          type: 'error'
        })
      }
    })
  },

  methods: {
    // 查询
    handleGet() {
      const dateTimeRange = this.form1.dateTimeRange
      const gameId = this.form1.selectGame
      const eventId = this.form1.selectEvent
      const userId = this.form1.userId
      const account = this.form1.account

      goldLogGet(dateTimeRange, gameId, eventId, userId, account).then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '获取数据失败: ' + response.msg,
            message: '',
            type: 'error'
          })
        }
      })
    }
  }
}
</script>
