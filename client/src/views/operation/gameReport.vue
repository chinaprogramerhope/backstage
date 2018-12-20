<template>
  <div>
    <el-form :inline="true" :model="form1" style="margin-top: 40px;">

      <el-form-item>
        <el-button>今天</el-button>
      </el-form-item>

      <el-form-item>
        <el-button>昨天</el-button>
      </el-form-item>

      <el-form-item>
        <el-button>本周</el-button>
      </el-form-item>

      <el-form-item>
        <el-button>上周</el-button>
      </el-form-item>

      <el-form-item>
        <el-button>本月</el-button>
      </el-form-item>

      <el-form-item>
        <el-button>上月</el-button>
      </el-form-item>

      <el-form-item label="选择日期">
        <el-date-picker
          v-model="dpValue1"
          type="daterange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
        />
      </el-form-item>

      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onSubmit">搜索</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'gameName', order:'descending'}"
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="gameName" label="游戏名称" align="center"/>
      <el-table-column prop="totalBet" label="总下注" align="center"/>
      <el-table-column prop="serviceTax" label="服务税收" align="center"/>
    </el-table>

    <!-- 分页 -->
    <el-pagination
      :current-page="currentPage"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="10"
      :total="40"
      align="center"
      layout="total, sizes, prev, pager, next, jumper"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    />

  </div>
</template>

<script>
export default {
  data() {
    return {
      // tableData
      tableData: [{
        gameName: '2018-11-11 11:11:11',
        totalBet: '2018-11-11 11:11:11',
        serviceTax: 'ok1'
      }, {
        gameName: '2018-11-11 11:11:11',
        totalBet: '2018-11-11 11:11:11',
        serviceTax: 'ok1'
      }]
    }
  }
}
</script>
