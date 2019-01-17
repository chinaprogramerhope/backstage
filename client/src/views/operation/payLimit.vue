<template>
  <div>

    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 30px; margin-top: 30px"
      label-position="right"
      label-width="100px">

      <el-form-item>
        <el-input v-model="form1.account" placeholder="玩家账号" clearable style="width: 120px"/>
      </el-form-item>

      <el-form-item>
        <el-date-picker
          v-model="form1.dateRange"
          type="daterange"
          range-separator="~"
          start-placeholde="开始日期"
          end-placeholde="结束日期"
          value-format="yyyy-MM-dd HH:mm:ss"
          style="width: 250px"
        />
      </el-form-item>

      <el-form-item>
        <el-input v-model="form1.keyWord" placeholder="原因关键字" clearable/>
      </el-form-item>

      <el-form-item label="操作人:">
        <el-select v-model="form1.selectOperator" style="width: 110px">
          <el-option
            v-for="item in form1.optionsOperator"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="">
        <el-button v-model="tips" type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
      </el-form-item>

      <el-form-item label="">
        <el-button v-model="tips" type="danger" size="small" @click="dialogFormAddVisible = true">添加充值黑名单</el-button>
      </el-form-item>

      <el-form-item label="">
        <el-button v-model="tips" type="danger" size="small" @click="handleSync()">同步黑名单到redis</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="account" label="玩家账号(禁止充值)" align="center"/>
      <el-table-column min-width="10%" prop="mobileNumber" label="操作人" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="添加时间" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="原因" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="操作" align="center">
        <template slot-scope="scope">
          <el-button type="primary" size="mini">修改</el-button>
        </template>
      </el-table-column>
    </el-table>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        selectChannelName: -1,
        optionsChannelName: [{
          label: '全部',
          value: -1
        }, {
          label: '发哥游戏Ios',
          value: 1
        }]

      },

      tableData: [{
        account: '11'
      }]
    }
  },

  created() {

  },

  methods: {

    // 添加游戏版本
    handleAdd() {

    }
  }
}
</script>
