<template>
  <div>

    <!-- 表单 -->
    <el-form :inline="true" :model="form1" align="left" style="margin-top: 30px">
      <!-- <el-form-item label="日期:">
        <el-date-picker
          v-model="form1.dpValue1"
          type="daterange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
        />
      </el-form-item> -->

      <!-- <el-form-item label="渠道:">
        <el-select v-model="form1.selectChannel">
          <el-option
            v-for="item in form1.optionsChannel"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="支付方式:">
        <el-select v-model="form1.selectPayType">
          <el-option
            v-for="item in form1.optionsPayType"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select> -->
      <!-- </el-form-item> -->

      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onGet">查询</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="id" label="id" sortable align="center"/>
      <el-table-column prop="sDate" label="sdate" sortable align="center"/>
      <el-table-column prop="gameType" label="游戏类型" sortable align="center"/>
      <el-table-column prop="serverId" label="服务器id" sortable align="center"/>
      <el-table-column prop="roomId" label="游戏房间id" sortable align="center"/>
      <el-table-column prop="systemProfit" label="系统利润" sortable align="center"/>
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

  </div>
</template>

<script>
import { systemProfitGet } from '@/api/operation'

export default {
  data() {
    return {
      form1: {
        dpValue1: '',
        selectChannel: -1,
        optionsChannel: [{
          label: '全部',
          value: -1
        }, {
          label: '发哥游戏Ios',
          value: 1
        }, {
          label: '酷锐游戏Ios',
          value: 2
        }],
        selectPayType: -1,
        optionsPayType: [{
          label: '全部',
          value: -1
        }, {
          label: '支付宝',
          value: 1
        }, {
          label: '微信',
          value: 2
        }, {
          label: '卡支付',
          value: 3
        }, {
          label: 'QQ钱包',
          value: 4
        }, {
          label: '京东钱包',
          value: 5
        }]
      },

      // tableData
      tableData: '',

      // 分页
      currentPage: 1
    }
  },

  created() {
    systemProfitGet().then(response => {
      if (response.code === 0) {
        this.tableData = response.data
      } else {
        this.$notify({
          title: '获取数据失败',
          message: '',
          type: 'error'
        })
      }
    })
  },

  methods: {

    // 查询
    onGet() {
      systemProfitGet().then(response => {
        if (response.code === 0) {
          this.tableData = response.data
        } else {
          this.$notify({
            title: '获取数据失败',
            message: '',
            type: 'error'
          })
        }
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
