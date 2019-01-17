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

      <el-form-item label="途径:">
        <el-select v-model="form1.selectWay" style="width: 150px">
          <el-option
            v-for="item in form1.optionsWay"
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
        <el-input v-model="form1.account" placeholder="用户账号" clearable style="width: 150px"/>
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
      <el-table-column min-width="10%" prop="id" label="玩家id" align="center"/>
      <el-table-column min-width="10%" prop="account" label="金豆变化" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="时间" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="结束金豆" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="起始金豆" align="center"/>
      <el-table-column min-width="10%" prop="operator" label="底注" align="center"/>
      <el-table-column min-width="10%" prop="account" label="游戏类型" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="事件类型" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="ip" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="房间id" align="center"/>
      <el-table-column min-width="10%" prop="recordTime" label="桌子id" align="center"/>
      <el-table-column min-width="10%" prop="operation" label="作为id" align="center"/>
    </el-table>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        selectGame: -1,
        optionsGame: [{
          label: '全部',
          value: -1
        }],

        selectWay: -1,
        optionsWay: [{
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

  },

  methods: {

    // 添加游戏版本
    handleAdd() {

    }
  }
}
</script>
