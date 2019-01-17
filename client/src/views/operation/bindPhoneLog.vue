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
        <el-input v-model="form1.account" placeholder="玩家账号" clearable/>
      </el-form-item>

      <el-form-item>
        <el-input v-model="form1.mobileNumber" placeholder="手机号" clearable/>
      </el-form-item>

      <el-form-item>
        <el-date-picker
          v-model="form1.dateRange"
          type="daterange"
          range-separator="~"
          start-placeholde="开始日期"
          end-placeholde="结束日期"
          value-format="yyyy-MM-dd HH:mm:ss"
        />
      </el-form-item>

      <el-form-item label="绑定或解绑:">
        <el-select v-model="form1.selectBind">
          <el-option
            v-for="item in form1.optionsBind"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="">
        <el-button v-model="tips" type="primary" size="small" icon="el-icon-search" @click="dialogFormAddVisible = true">查询</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="account" label="玩家账号" align="center"/>
      <el-table-column min-width="10%" prop="mobileNumber" label="手机号" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="绑定/解绑" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="操作时间" align="center"/>
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
